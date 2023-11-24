<?php

namespace Lernfeld1011\controllers;

use Lernfeld1011\infrastructure\Factory;
use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\SolarBank;
use Lernfeld1011\models\SolarBankUUID;

/**
 * Representational State Transfer - Application Programming Interface
 * Maybe a better name for our Interface Controller?
 * This Interface will be accessed by the Frontend for data exchange.
 */
class RestApi
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
        $arr = [];
        $solarBanks = $this->factory->createSolarBankReader()->readAll();
        foreach ($solarBanks as $solarBank)
        {
            $weatherNode = $this->factory->createOpenMeteoReader()->getWeatherData($solarBank->getCoordinate());
            $arr[$solarBank->getUuid()]['Solarbank'] = $this->factory->getSolarBankMapper()->toArray($solarBank);
            $arr[$solarBank->getUuid()]['WeatherNode'] = $this->factory->getWeatherNodeMapper()->toArray($weatherNode);
        }
        // array<SolarBank> = factory -> solarBankreader -> getAllSolarbanks
        // WeatherNode = solarBank -> coordinate -> weatherdaten anfragen
        // array[uuid][WeatherNode] = Weathernode
        //Alternative (bei langsamer API): gebe frontend solarbank-array. Frontend fragt pro solarbank die weathernode an.
        return json_encode($arr);
    }

    public function getWeatherNode(SolarBankUUID $solarBankUUID): string
    {
        $solarBank = $this->factory->createSolarBankReader()->readByUuid($solarBankUUID);
        //return $this->getWeatherNodesFromHamburg();
        //$solarBank = $this->factory->createSolarBank(Coordinate::fromFloat(8.1,-19.6),'TestInsertUUID',2,19 );
        //return $this->factory->createSolarBankWriter()->insert($solarBank);
        return $this->factory->getWeatherNodeMapper()->toJSON($this->factory->createOpenMeteoReader()->getWeatherData($solarBank->getCoordinate()));
    }
}
