<?php

namespace App\Data;

use PDO;

class Config
{
    private $data = [];

    public function __construct(array $env)
    {
        $this->data = [
            'site' => [
                'environment' => $env['ENV'],
                'title' => 'Welcome!',
                'description' => 'Basic auth system built with PHP.',
            ],
            'database' => [
                'main' => [
                    'driver' => $env['DB_DRIVER'],
                    'host' => $env['DB_HOST'],
                    'username' => $env['DB_USERNAME'],
                    'password' => $env['DB_PASSWORD'],
                    'name' => $env['DB_NAME'],
                    'pdo_options' => [
                        PDO::ATTR_PERSISTENT => false,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    ]
                ],
            ],
            'plates_templates' => [
                'folders' => [
                    'template' => 'templates/',
                ],
            ],
        ];
    }

    public function get()
    {
        return $this->data;
    }
}
