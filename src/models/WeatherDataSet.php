<?php

class WeatherDataSet
{

    /** @var int timestamp */
    private $time;
    private $temperature;
    private $terrestrialRadiation;
    private $terrestrialRadiationInstant;
    private $uvIndex;

    private $uvIndexClearSky;

    public function __construct(int $time, float $temperature, float $terrestrialRadiation, float $terrestrialRadiationInstant,
    float $uvIndex, float $uvIndexClearSky)
    {
        $this->time = $time;
        $this-> temperature = $temperature;
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