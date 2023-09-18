<?php

namespace Lernfeld1011\controllers;

use Lernfeld1011\infrastructure\Factory;
use Lernfeld1011\models\SolarBank;

/**
 * Representational State Transfer - Application Programming Interface
 * Maybe a better name for our Interface Controller?
 * This Interface will be accessed by the Frontend for data exchange.
 */
class RestAPI
{
    private Factory $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function aMethod(): string
    {
        return 'Dies ist ein Test';
    }

    public function getWeatherNodesFromHamburg(): string
    {
        // array<SolarBank> = factory -> solarBankreader -> getAllSolarbanks
        // WeatherNode = solarBank -> coordinate -> weatherdaten anfragen
        // array[uuid][WeatherNode] = Weathernode
        //Alternative (bei langsamer API): gebe frontend solarbank-array. Frontend fragt pro solarbank die weathernode an.
        return '';
    }

    public function getWeatherNode(string $solarBankUUID): string
    {
        return $this->factory->getWeatherNodeMapper()->toJSON($this->factory->createOpenMeteoClient()->getWeatherDataFixture());
        /** @var SolarBank $solarBank */
        $solarBank = $this->factory->solarBankReader()->read($solarBankUUID);
        $this->factory->createOpenMeteoClient()->getWeatherData($solarBank->getCoordinate());

        // uuid -> solarbank -> coordinate -> request externe APi
        return '';
    }
}
