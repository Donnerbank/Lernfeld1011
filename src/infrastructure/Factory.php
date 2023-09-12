<?php

namespace Lernfeld1011\infrastructure;

/**
 * Factory: Objects are created here and used in other Classes (Dependency Injection)
 */
class Factory
{
    /*
     * Configuration for Future Database accesses
     */
    private \Configuration $configuration;

    public function __construct(\Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getSolarBankMapper(): SolarBankMapper
    {
        return new SolarBankMapper($this);
    }

    public function getWeatherNodeMapper(): WeatherNodeMapper
    {
        return new WeatherNodeMapper($this);
    }
}
