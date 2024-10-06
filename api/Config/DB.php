<?php

namespace Config;

class DB
{
    public static function get()
    {
        return [
            'host' => getenv('DB_HOST', 'localhost'),
            'user' => getenv('DB_USER', 'root'),
            'password' => getenv('DB_PASSWORD', 'root'),
            'dbname' => getenv('DB_NAME', 'course_catalog')
        ];
    }
}
