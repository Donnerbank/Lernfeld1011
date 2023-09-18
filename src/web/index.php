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
// CI: https://github.com/tillmannschiffler/simplequeue/blob/main/.github/workflows/integrate.yaml
try {
    /*      Example Routing
            Router::add('/api/v1/controllername/method/parameter1/parameter2/parameter3', function () {
            $controller = new ControllerName();
            $controller->method(parameter1,parameter2,parameter3);
        });*/

    // test the Routing
    Router::add('/api/v1/restapi/amethod', function () use ($factory) {
        $controller = new RestAPI($factory);
        $s = $controller->aMethod();
        echo $s;
    }, 'get');
    Router::add('/api/v1/restapi/test', function () use ($factory) {
        $controller = new RestAPI($factory);
        $s = $controller->getWeatherNode('');
        echo $s;
    }, 'get');
    // Error in case Route was not found
    Router::pathNotFound(function () {
        echo 'Es wurde keine Route gefunden.';
    });

    Router::methodNotAllowed(function () {
        echo 'Method not allowed';
    });
    // run the Router and check for matched Path
    Router::run($config->getRouterBase());
} catch (Exception $exception) {
    echo 'Fehler. Error Controller hier.';
}
exit();
