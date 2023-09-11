<?php

use Lernfeld1011\models\Date;

class WeatherNode
{
    private Coordinate $coordinate;

    /** @var array<int, WeatherDataSet> */
    private array $hourlyWeatherData;

    private Date $date;

    public function __construct(Coordinate $coordinate, Date $date)
    {
        $this->coordinate = $coordinate;
        $this->date = $date;
        $this->hourlyWeatherData = [];
    }

    public function addWeatherData(WeatherDataSet $weatherData): void
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

    public function getDate(): string
    {
        return $this->date;
    }
}
