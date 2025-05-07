<?php

declare(strict_types=1);

namespace App\Ship\Tests\Unit\Migrations;

use App\Ship\Tests\ShipTestCase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ShipMigrationTest extends ShipTestCase
{
    public function testJobsTableHasExpectedColumns(): void
    {
        $table = 'jobs';
        $driver = Schema::getConnection()->getDriverName();
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            default  => 'bigint',
        };
        $integer = match ($driver) {
            'mysql' => 'int',
            default => 'integer',
        };
        $smallint = match ($driver) {
            'mysql'  => 'tinyint',
            'sqlite' => 'integer',
            default  => 'smallint',
        };
        $string = match ($driver) {
            'mysql' => 'varchar',
            default => 'string',
        };
        $text = match ($driver) {
            'mysql' => 'longtext',
            default => 'text',
        };

        $columns = [
            'id'           => $bigint,
            'queue'        => $string,
            'payload'      => $text,
            'attempts'     => $smallint,
            'reserved_at'  => $integer,
            'available_at' => $integer,
            'created_at'   => $integer,
        ];

        $this->assertDatabaseTable($table, $columns);
    }

    public function testFailedJobsTableHasExpectedColumns(): void
    {
        $table = 'failed_jobs';
        $driver = Schema::getConnection()->getDriverName();
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            default  => 'bigint',
        };
        $string = match ($driver) {
            'mysql' => 'varchar',
            default => 'string',
        };
        $datetime = match ($driver) {
            'mysql' => 'timestamp',
            default => 'datetime',
        };
        $text = match ($driver) {
            'mysql' => 'longtext',
            default => 'text',
        };

        $columns = [
            'id'         => $bigint,
            'connection' => 'text',
            'queue'      => 'text',
            'payload'    => $text,
            'exception'  => $text,
            'failed_at'  => $datetime,
            'uuid'       => $string,
        ];

        $this->assertDatabaseTable($table, $columns);
    }

    public function testNotificationsTableHasExpectedColumns(): void
    {
        $table = 'notifications';
        $driver = Schema::getConnection()->getDriverName();
        $guid = match ($driver) {
            'pgsql' => 'guid',
            'mysql' => 'char',
            default => 'string',
        };
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            default  => 'bigint',
        };
        $string = match ($driver) {
            'mysql' => 'varchar',
            default => 'string',
        };
        $datetime = match ($driver) {
            'mysql' => 'timestamp',
            default => 'datetime',
        };

        $columns = [
            'id'              => $guid,
            'type'            => $string,
            'notifiable_id'   => $bigint,
            'notifiable_type' => $string,
            'data'            => 'text',
            'read_at'         => $datetime,
            'created_at'      => $datetime,
            'updated_at'      => $datetime,
        ];

        $this->assertDatabaseTable($table, $columns);
    }
}
