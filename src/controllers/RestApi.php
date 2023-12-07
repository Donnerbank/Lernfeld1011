<?php

namespace Lernfeld1011\controllers;

use Lernfeld1011\infrastructure\Factory;
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

    /** Returns all SolarBanks from the Database. Also request the WeatherData for the next 24 hours.
     * Returns data as JSON.
     */
    public function getWeatherNodesFromHamburg(): string
    {
        $arr = [];
        $solarBanks = $this->factory->createSolarBankReader()->readAll();
        foreach ($solarBanks as $solarBank) {
            $weatherNode = $this->factory->createOpenMeteoReader()->getWeatherData($solarBank->getCoordinate());
            $arr[$solarBank->getUuid()]['Solarbank'] = $this->factory->getSolarBankMapper()->toArray($solarBank);
            $arr[$solarBank->getUuid()]['WeatherNode'] = $this->factory->getWeatherNodeMapper()->toArray($weatherNode);
        }

        return json_encode($arr);
    }

    /** requests WeatherData for single SolarBank. Uses UUID. Not used yet, may be for future */
    public function getWeatherNode(SolarBankUUID $solarBankUUID): string
    {
        $solarBank = $this->factory->createSolarBankReader()->readByUuid($solarBankUUID);

        return $this->factory->getWeatherNodeMapper()->toJSON($this->factory->createOpenMeteoReader()->getWeatherData($solarBank->getCoordinate()));
    }

    /** Method to add a SolarBank to the DataBase. Not used, since we don't want clients to add random Stuff. Future use for Admins */
    public function addSolarBank(string $json): bool
    {
        $solarBank = $this->factory->getSolarBankMapper()->fromJSON($json);
        if (empty($solarBank->getName())) {
            return false;
        }

        return $this->factory->createSolarBankWriter()->insert($solarBank);
    }
}
