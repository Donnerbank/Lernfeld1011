<?php

namespace Lernfeld1011\models;
class WeatherDataSet
{
    /** @var int timestamp */
    private int $time;

    private float $temperature;

    private float $terrestrialRadiation;

    private float $terrestrialRadiationInstant;

    private float $uvIndex;

    private float $uvIndexClearSky;

    public function __construct(int $time, float $temperature, float $terrestrialRadiation, float $terrestrialRadiationInstant,
        float $uvIndex, float $uvIndexClearSky)
    {
        $this->time = $time;
        $this->temperature = $temperature;
        $this->terrestrialRadiation = $terrestrialRadiation;
        $this->terrestrialRadiationInstant = $terrestrialRadiationInstant;
        $this->uvIndex = $uvIndex;
        $this->uvIndexClearSky = $uvIndexClearSky;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getTerrestrialRadiation(): float
    {
        return $this->terrestrialRadiation;
    }

    public function getTerrestrialRadiationInstant(): float
    {
        return $this->terrestrialRadiationInstant;
    }

    public function getUvIndex(): float
    {
        return $this->uvIndex;
    }

    public function getUvIndexClearSky(): float
    {
        return $this->uvIndexClearSky;
    }
}
