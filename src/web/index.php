<?php

require __DIR__ . '/../../Configuration/Configuration.php';
require __DIR__ . '/../vendor/autoload.php';

use infrastructure\Factory;
use infrastructure\Router;
use views\Renderer;

session_start();

error_reporting(E_ERROR);
ini_set('display_errors',true);

$render = new Renderer();
$config = new Configuration();
$factory = new Factory($config);

//All Routes
try
{
/*    Router::add('/addresseHere', function () use ($render, $factory)
    {
        $controller = new ???Controler($render, $factory);
        $controller->doSomething();
    });*/

    Router::pathNotFound(function()
    {
        echo 'Es wurde keine Route gefunden.';
    });

    Router::run($config->getRouterBase());
}
catch (Exception $exception)
{
    echo 'Fehler. Error Controller hier.';
}
die();