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
            'host' => getenv('DB_HOST', 'localhost'),
            'user' => getenv('DB_USER', 'root'),
            'password' => getenv('DB_PASSWORD', 'root'),
            'dbname' => getenv('DB_NAME', 'course_catalog')
        ];
    }
}
