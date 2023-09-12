<?php

namespace Lernfeld1011\models;

/** Weather Data for a single hour of the day */
class WeatherDataSet
{
    /** @var int The corresponding hour as unix timestamp */
    private int $time;

    /** @var float in Celsius */
    private float $temperature;

    /** Definition: Terrestrial Radiation
     * Electromagnetic radiation emitted by the Earth's surface and atmosphere is called terrestrial or longwave radiation
     * Most of the emitted longwave radiation warms the lower atmosphere, which in turn warms our planet's surface.
     */

    /** @var float used for future calculation of generated power */
    private float $terrestrialRadiation;

    /** @var float might also use for future calculation */
    private float $terrestrialRadiationInstant;

    /** @var float might use for future information */
    private float $uvIndex;

    /** @var float might use for future information */
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
