<?php

namespace Lernfeld1011\infrastructure;

use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\SolarBank;

/**
 * Maps an array or a json string to a SolarBank Object and vice versa.
 */
class SolarBankMapper
{
    private Factory $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function fromArray(array $arr): SolarBank
    {
        // Sets a default value, if the given is not valid
        $long = 0;
        $lat = 0;
        $name = '';
        $trafficLightValue = 0;
        $kilowattPower = 0;

        // Checks the array for values, validates and assigns them
        // Coordinate attributes must be float values.
        if (! empty($arr['longitude'])) {
            $long = floatval($arr['longitude']);
        }
        if (! empty($arr['long'])) {
            $long = floatval($arr['long']);
        }
        if (! empty($arr['latitude'])) {
            $lat = floatval($arr['latitude']);
        }
        if (! empty($arr['lat'])) {
            $lat = floatval($arr['lat']);
        }
        if (! empty($arr['name'])) {
            $name = $arr['name'];
        }
        // Traffic Light Value should be between 1 and 4
        if (! empty($arr['trafficLightValue']) && intval($arr['trafficLightValue']) > 0 && intval($arr['trafficLightValue']) < 5) {
            $trafficLightValue = $arr['trafficLightValue'];
        }
        if (! empty($arr['ampelWert']) && intval($arr['ampelWert']) > 0 && intval($arr['ampelWert']) < 5) {
            $trafficLightValue = $arr['ampelWert'];
        }
        if (! empty($arr['kilowattPower'])) {
            $kilowattPower = $arr['kilowattPower'];
        }

        $coordinate = Coordinate::fromFloat($lat, $long);

        return $this->factory->createSolarBank($coordinate, $name, $trafficLightValue, $kilowattPower, $arr['uuid'] ?? '');
    }

    public function fromJSON(string $json): SolarBank
    {
        return $this->fromArray(json_decode($json, true));
    }

    public function toArray(SolarBank $solarBank): array
    {
        $arr = [];
        // Receives Values from SolarBank Object
        $arr['longitude'] = $solarBank->getCoordinate()->getLongitude();
        $arr['long'] = $solarBank->getCoordinate()->getLongitude();
        $arr['latitude'] = $solarBank->getCoordinate()->getLatitude();
        $arr['lat'] = $solarBank->getCoordinate()->getLatitude();
        // Puts Coordinate as readable string
        $arr['coordinate'] = $solarBank->getCoordinate()->getCoordinateAsString();
        $arr['name'] = $solarBank->getName();
        $arr['trafficLightValue'] = $solarBank->getTrafficLightValue();
        $arr['val'] = $solarBank->getTrafficLightValue();
        $arr['kilowattPower'] = $solarBank->getKilowattPower();
        $arr['power'] = $solarBank->getKilowattPower();

        return $arr;
    }

    public function toJSON(SolarBank $solarBank): string
    {
        return json_encode($this->toArray($solarBank));
    }
}
