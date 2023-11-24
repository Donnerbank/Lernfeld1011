<?php

namespace Lernfeld1011\infrastructure;

use Lernfeld1011\controllers\OpenMeteoApi;
use Lernfeld1011\infrastructure\database\SolarBankReader;
use Lernfeld1011\infrastructure\database\SolarBankWriter;
use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\Date;
use Lernfeld1011\models\SolarBank;
use Lernfeld1011\models\WeatherDataSet;
use Lernfeld1011\models\WeatherNode;
use PDO;

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

    public function createSolarBank(Coordinate $coordinate, string $name, int $trafficLightValue, int $kilowattPower, string $uuid = ''): SolarBank
    {
        return new SolarBank($coordinate, $name, $trafficLightValue, $kilowattPower, $uuid);
    }

    public function createWeatherNode(Coordinate $coordinate, Date $date): WeatherNode
    {
        return new WeatherNode($coordinate, $date);
    }

    public function createWeatherDataSet(int $time, float $temperature, float $terrestrialRadiation,
        float $terrestrialRadiationInstant, float $uvIndex, float $uvIndexClearSky): WeatherDataSet
    {
        return new WeatherDataSet($time, $temperature, $terrestrialRadiation, $terrestrialRadiationInstant, $uvIndex, $uvIndexClearSky);
    }

    public function createOpenMeteoReader(): OpenMeteoReader
    {
        return new OpenMeteoReader(new OpenMeteoApi($this->getWeatherNodeMapper(),$this->configuration->meteoApiUrl()));
    }

    public function createSolarBankReader() : SolarBankReader
    {
        return new SolarBankReader($this->createLocalPDO(),$this->getSolarBankMapper());
    }

    public function createSolarBankWriter(): SolarBankWriter
    {
        return new SolarBankWriter($this->createLocalPDO());
    }

    public function createLocalPDO(): PDO
    {
        return new PDO(
            $this->configuration->getLocalDsn(),
            $this->configuration->getLocalUser(),
            $this->configuration->getLocalPass()
        );
    }
}
