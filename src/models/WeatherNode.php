<?php

namespace Lernfeld1011\models;

/** Our Base WeatherNode Modell that contains the hourly weather information for a certain date in a certain Location */
class WeatherNode
{
    /** @var Coordinate Geographical Location of this Weather Node */
    private Coordinate $coordinate;


    /** @var array<int, WeatherDataSet>
     * contains the hourly Weather Data.
     * Uses the hour of the day as key for searching and sorting purposes. */
    private array $hourlyWeatherData;

    /** @var Date Value Object that contains day, month and year as integer */
    private Date $date;

    public function __construct(Coordinate $coordinate, Date $date)
    {
        $this->coordinate = $coordinate;
        $this->date = $date;
        // The hourly Weather Data is initilaized as ampty array.
        $this->hourlyWeatherData = [];
    }

    /** Adds a WeatherData set to the WeatherNode. Writes the hour as key. */
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

    public function getDate(): Date
    {
        return $this->date;
    }
}
