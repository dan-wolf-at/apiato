<?php

declare(strict_types=1);

namespace App\Ship\Parents\Actions;

use Apiato\Core\Abstracts\Actions\Action as AbstractAction;
use App\Ship\Parents\Traits\TransactionInterceptorTrait;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Action extends AbstractAction
{
    use TransactionInterceptorTrait;
}
