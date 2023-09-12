<?php

use Lernfeld1011\controllers\RestAPI;
use Lernfeld1011\infrastructure\Factory;
use Lernfeld1011\infrastructure\Router;
use Lernfeld1011\views\Renderer;

require __DIR__.'/../../Configuration/Configuration.php';
require __DIR__.'/../../vendor/autoload.php';

session_start();

error_reporting(E_ERROR);
ini_set('display_errors', true);

$render = new Renderer();
$config = new Configuration();
$factory = new Factory($config);

// Add Routes to our Router
try {
/*      Example Routing
        Router::add('/api/v1/controllername/method/parameter1/parameter2/parameter3', function () {
        $controller = new ControllerName();
        $controller->method(parameter1,parameter2,parameter3);
    });*/

    // test the Routing
    Router::add('/api/v1/restapi/amethod', function () {
        $controller = new RestAPI();
        $s = $controller->aMethod();
        echo $s;
    });
    // Error in case Route was not found
    Router::pathNotFound(function () {
        echo 'Es wurde keine Route gefunden.';
    });
    // run the Router and check for matched Path
    Router::run($config->getRouterBase());
} catch (Exception $exception) {
    echo 'Fehler. Error Controller hier.';
}
exit();
