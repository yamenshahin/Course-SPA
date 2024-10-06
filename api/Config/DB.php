<?php

namespace Config;

class DB
{
    /**
     * Get database config
     *
     * @return array
     */
    public static function get(): array
    {
        return [
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'user' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? '',
            'dbname' => $_ENV['DB_NAME'] ?? 'test',
        ];
    }
}
