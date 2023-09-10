<?php

class WeatherNode
{

    private $coordinate;

    /** @var <int, WeatherDataSet> */
    private $hourlyWeatherData;

    public function __construct(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;
        $this->hourlyWeatherData = [];
    }

    public function addWeatherData(WeatherDataSet $weatherData):void
    {
        $this->hourlyWeatherData[$weatherData->getTime()] = $weatherData;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    /**
     * @return array<int,WeatherDataSet>
     */
    public function getHourlyWeatherData(): array
    {
        return $this->hourlyWeatherData;
    }


}