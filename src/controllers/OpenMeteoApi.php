<?php

namespace Lernfeld1011\controllers;

use Lernfeld1011\infrastructure\WeatherNodeMapper;
use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\WeatherNode;

class OpenMeteoApi
{
    private WeatherNodeMapper $mapper;
    private string $url;

    public function __construct(WeatherNodeMapper $mapper, string $url)
    {
        $this->mapper = $mapper;
        $this->url = $url;
    }

    public function getData(Coordinate $coordinate): WeatherNode
    {
        $url = sprintf($this->url,$coordinate->getLatitude(), $coordinate->getLongitude());
        return $this->mapper->fromJSON(file_get_contents($url));
    }

    public function getMapper(): WeatherNodeMapper
{
    return $this->mapper;
}
}