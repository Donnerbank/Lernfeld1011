<?php

namespace Lernfeld1011\infrastructure;

use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\WeatherNode;

class OpenMeteoClient
{
    private Factory $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function getWeatherData(Coordinate $coordinate): WeatherNode
    {

        return $this->factory->getWeatherNodeMapper()->fromJSON();
    }

    public function getWeatherDataFixture(): WeatherNode
    {
        $data = file_get_contents(__DIR__.'/../../testWeather.json');

        return $this->factory->getWeatherNodeMapper()->fromJSON($data);
    }
}
