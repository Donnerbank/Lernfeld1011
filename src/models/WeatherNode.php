<?php

class WeatherNode
{

    private Coordinate $coordinate;

    /** @var array<int, WeatherDataSet> */
    private array $hourlyWeatherData;

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