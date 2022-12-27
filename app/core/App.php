<?php

namespace App\Core;

use App\Core\Router;
use App\Core\Container;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

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
        // Site routing
        $iterator = new RecursiveDirectoryIterator('../routes/');
        foreach (new RecursiveIteratorIterator($iterator) as $filename) {
            if (strpos($filename, '.php') !== false) {
                require_once($filename);
            }
        }
        $this->router->checkRoute();
    }

    /**
     * Establish any container class bindings for the application
     */
    public function setClassBindings(): self
    {
        // if we would want to manually set the DB in the container
        // making sure there is only one DB connection per request
        /* $db = new DB();
        $this->container->set(
            DB::class,
            function () use ($db) {
                return $db;
            }
        ); */

        return $this;
    }
}
