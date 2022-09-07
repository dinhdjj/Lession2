<?php

namespace App\Core;

use App\Core\Interfaces\Application as IApplication;
use App\Core\Interfaces\Database as IDatabase;
use PDO;

class Database implements IDatabase
{
    protected static PDO $connection;

    /**
     * {@inheritDoc}
     */
    public static function boot(IApplication $application): void
    {
        $DNS = $application->config('database.dns');
        $USER = $application->config('database.user');
        $PASSWORD = $application->config('database.password');

        static::$connection = new PDO($DNS, $USER, $PASSWORD);
        static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * {@inheritDoc}
     */
    public static function connection(): PDO
    {
        return static::$connection;
    }

    /**
     * {@inheritDoc}
     */
    public static function insert(string $statement, array $data = []): bool
    {
        $query = static::$connection->prepare($statement);

        return $query->execute($data);
    }

    /**
     * {@inheritDoc}
     */
    public static function select(string $statement, array $data = []): array
    {
        $query = static::$connection->prepare($statement);
        $query->execute($data);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritDoc}
     */
    public static function update(string $statement, array $data = []): bool
    {
        $query = static::$connection->prepare($statement);

        return $query->execute($data);
    }

    /**
     * {@inheritDoc}
     */
    public static function delete(string $statement, array $data = []): bool
    {
        $query = static::$connection->prepare($statement);

        return $query->execute($data);
    }
}
