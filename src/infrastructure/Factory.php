<?php

namespace Lernfeld1011\infrastructure;


class Factory
{
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
