<?php

use Lernfeld1011\Configuration\Configuration;
use Lernfeld1011\controllers\RestApi;
use Lernfeld1011\infrastructure\Factory;
use Lernfeld1011\infrastructure\Router;
use Lernfeld1011\views\Renderer;

require __DIR__.'/../Configuration/Configuration.php';
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
    Router::add('/api/v1/restapi/amethod', function () use ($factory) {
        $controller = new RestApi($factory);
        $s = $controller->aMethod();
        echo $s;
    }, 'get');
    Router::add('/api/v1/restapi/test', function () use ($factory) {
        $controller = new RestApi($factory);
        $uuid = \Lernfeld1011\models\SolarBankUUID::fromString('A63fd87a9B-654fA-46d7N-bef9A-f81bNc360A104b');
        $factory->createSolarBankReader()->readByUuid($uuid);

        $s = $controller->getWeatherNode($uuid);
        echo $s;
    }, 'get');
    Router::add('/api/v1/restapi/addSolarBank', function () use ($factory)
    {
        $json = file_get_contents('php://input');
        echo $json;
    }, 'get');
    // 63fd87a9B-654fA-46d7N-bef9A-f81bNc360A104b
    Router::add('/api/v1/restapi/getSolarBankData/(.*)', function ($uuid) use ($factory)
    {
        throw new Exception('Not Supported');
        $controller = new RestApi($factory);
        $uuid = \Lernfeld1011\models\SolarBankUUID::fromString($uuid);
        $factory->createSolarBankReader()->readByUuid($uuid);
        echo $controller->getWeatherNode($uuid);
    }, 'get');
    Router::add('/api/v1/restapi/getHamburgWeatherData', function () use ($factory) {
        $controller = new RestApi($factory);
        $s = $controller->getWeatherNodesFromHamburg();
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
    $arr = ['response' => 'Error','message' => $exception->getMessage()];
    echo json_encode($arr);
}
exit();
