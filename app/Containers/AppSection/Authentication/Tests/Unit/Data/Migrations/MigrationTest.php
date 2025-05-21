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
        $string = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'varchar',
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
            'id'         => $string,
            'user_id'    => $bigint,
            'client_id'  => $bigint,
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
            'id'         => $string,
            'user_id'    => $bigint,
            'client_id'  => $bigint,
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
        $string = match ($driver) {
            'sqlite', 'mysql', 'pgsql' => 'varchar',
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
            'id'              => $string,
            'access_token_id' => $string,
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
        $bool = match ($driver) {
            'mysql', 'sqlite' => 'tinyint',
            default => 'bool',
        };
        $timestamp = match ($driver) {
            'mysql', 'pgsql' => 'timestamp',
            default => 'datetime',
        };

        $columns = [
            'id'                     => $bigint,
            'user_id'                => $bigint,
            'name'                   => $string,
            'secret'                 => $string,
            'provider'               => $string,
            'redirect'               => 'text',
            'personal_access_client' => $bool,
            'password_client'        => $bool,
            'revoked'                => $bool,
            'created_at'             => $timestamp,
            'updated_at'             => $timestamp,
        ];

        self::assertDatabaseTable('oauth_clients', $columns);
    }

    public function testOAuthPersonamAccessClientsTableHasExpectedColumns(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        $bigint = match ($driver) {
            'sqlite' => 'integer',
            'pgsql'  => 'int8',
            default  => 'bigint',
        };
        $timestamp = match ($driver) {
            'mysql', 'pgsql' => 'timestamp',
            default => 'datetime',
        };

        $columns = [
            'id'         => $bigint,
            'client_id'  => $bigint,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];

        self::assertDatabaseTable('oauth_personal_access_clients', $columns);
    }
}
