<?php

namespace App\Core;

use App\Core\DB;
use App\Core\Router;
use App\Models\User;
use App\Core\Container;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Interfaces\UserDataInterface;

class App
{
    protected $router;
    protected $container;

    public function __construct(Container $container, Router $router)
    {
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * Start the site
     */
    public function run(): void
    {
        $iterator = new RecursiveDirectoryIterator('../routes/');
        foreach (new RecursiveIteratorIterator($iterator) as $filename) {
            if (strpos($filename, '.php') !== false) {
                require_once $filename;
            }
        }
        $this->router->run();
    }

    /**
     * Establish any container class bindings for the application
     */
    public function containerSetup(): self
    {
        $this->container->setOnce(
            DB::class,
            function ($container) {
                return new DB();
            }
        );
        $this->container->setOnce(
            UserDataInterface::class,
            function ($container) {
                return new User($container->get(DB::class));
            }
        );

        return $this;
    }
}
