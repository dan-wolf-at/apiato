<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Data\Migrations;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class MigrationTest extends UnitTestCase
{
    public function testOAuthAuthCodesTableHasExpectedColumns(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            'pgsql'  => 'int8',
            default  => 'bigint',
        };
        $char = match ($driver) {
            'sqlite', 'mysql' => 'char',
            'pgsql' => 'bpchar',
            default => 'string',
        };
        $uuid = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'uuid',
            default => 'guid',
        };
        $bool = match ($driver) {
            'mysql', 'sqlite' => 'tinyint',
            default => 'bool',
        };
        $datetime = match ($driver) {
            'mysql', 'sqlite' => 'datetime',
            default => 'timestamp',
        };

        $columns = [
            'id'         => $char,
            'user_id'    => $bigint,
            'client_id'  => $uuid,
            'scopes'     => 'text',
            'revoked'    => $bool,
            'expires_at' => $datetime,
        ];

        self::assertDatabaseTable('oauth_auth_codes', $columns);
    }

    public function testOAuthAccessTokenTableHasExpectedColumns(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            'pgsql'  => 'int8',
            default  => 'bigint',
        };
        $string = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'varchar',
            default => 'string',
        };
        $char = match ($driver) {
            'sqlite', 'mysql' => 'char',
            'pgsql' => 'bpchar',
            default => 'string',
        };
        $uuid = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'uuid',
            default => 'guid',
        };
        $datetime = match ($driver) {
            'mysql', 'sqlite' => 'datetime',
            default => 'timestamp',
        };
        $timestamp = match ($driver) {
            'mysql', 'pgsql' => 'timestamp',
            default => 'datetime',
        };
        $bool = match ($driver) {
            'mysql', 'sqlite' => 'tinyint',
            default => 'bool',
        };

        $columns = [
            'id'         => $char,
            'user_id'    => $bigint,
            'client_id'  => $uuid,
            'name'       => $string,
            'scopes'     => 'text',
            'revoked'    => $bool,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'expires_at' => $datetime,
        ];

        self::assertDatabaseTable('oauth_access_tokens', $columns);
    }

    public function testOAuthRefreshTokenTableHasExpectedColumns(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $char = match ($driver) {
            'sqlite', 'mysql' => 'char',
            'pgsql' => 'bpchar',
            default => 'string',
        };
        $bool = match ($driver) {
            'mysql', 'sqlite' => 'tinyint',
            default => 'bool',
        };
        $datetime = match ($driver) {
            'mysql', 'sqlite' => 'datetime',
            default => 'timestamp',
        };

        $columns = [
            'id'              => $char,
            'access_token_id' => $char,
            'revoked'         => $bool,
            'expires_at'      => $datetime,
        ];

        self::assertDatabaseTable('oauth_refresh_tokens', $columns);
    }

    public function testOAuthClientsTableHasExpectedColumns(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            'pgsql'  => 'int8',
            default  => 'bigint',
        };
        $string = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'varchar',
            default => 'string',
        };
        $uuid = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'uuid',
            default => 'guid',
        };
        $bool = match ($driver) {
            'mysql', 'sqlite' => 'tinyint',
            default => 'bool',
        };
        $timestamp = match ($driver) {
            'mysql', 'pgsql' => 'timestamp',
            default => 'datetime',
        };

        $columns = [
            'id'            => $uuid,
            'owner_type'    => $string,
            'owner_id'      => $bigint,
            'name'          => $string,
            'secret'        => $string,
            'provider'      => $string,
            'redirect_uris' => 'text',
            'grant_types'   => 'text',
            'revoked'       => $bool,
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp,
        ];

        self::assertDatabaseTable('oauth_clients', $columns);
    }

    public function testOAuthDeviceCodesTableHasExpectedColumns(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            'pgsql'  => 'int8',
            default  => 'bigint',
        };
        $char = match ($driver) {
            'sqlite', 'mysql' => 'char',
            'pgsql' => 'bpchar',
            default => 'string',
        };
        $uuid = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'uuid',
            default => 'guid',
        };
        $bool = match ($driver) {
            'mysql', 'sqlite' => 'tinyint',
            default => 'bool',
        };
        $timestamp = match ($driver) {
            'mysql', 'pgsql' => 'timestamp',
            default => 'datetime',
        };

        $columns = [
            'id'               => $char,
            'user_id'          => $bigint,
            'client_id'        => $uuid,
            'user_code'        => $char,
            'scopes'           => 'text',
            'revoked'          => $bool,
            'user_approved_at' => $timestamp,
            'last_polled_at'   => $timestamp,
            'expires_at'       => $timestamp,
        ];

        self::assertDatabaseTable('oauth_device_codes', $columns);
    }
}
