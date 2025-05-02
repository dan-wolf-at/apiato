<?php

declare(strict_types=1);

namespace App\Ship\Parents\Traits;

use App\Ship\Parents\Actions\Action;
use Illuminate\Database\ConnectionInterface;
use Throwable;

trait TransactionInterceptorTrait
{
    /**
     * This method is used to intercept the method calls and wrap them in a transaction.
     * It is used in the following way:
     * $this->transactionInterceptor()->run($transporter);
     * This will wrap the run method in a transaction.
     * If the run method throws an exception, the transaction will be rolled back.
     * If the run method does not throw an exception, the transaction will be committed.
     * This is useful for actions that need to be atomic.
     */
    public function transactionInterceptor(): static
    {
        /**
         * @var Action $this
         */
        return new class ($this) {
            protected ConnectionInterface $transactionManager;

            public function __construct(protected object $class)
            {
                $this->transactionManager = app(ConnectionInterface::class);
            }

            public function __call(string $method, array $arguments)
            {
                try {
                    $this->transactionManager->beginTransaction();
                    $result = $this->class->{$method}(...$arguments);
                    $this->transactionManager->commit();

                    return $result;
                } catch (Throwable $throwable) {
                    $this->transactionManager->rollBack();
                    throw $throwable;
                }
            }
        };
    }
}
