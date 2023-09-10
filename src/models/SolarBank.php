<?php

// solarbank: soll standort haben (koordinate), name, ampelwert (1-4), kilowattleistung (terrestial radiation + ?)
class SolarBank
{
    private $coordinate;
    private $name;
    private $trafficLightValue;
    private $kilowattPower;

    public function __construct(Coordinate $coordinate, string $name, int $trafficLightValue, int $kilowattPower)
    {
        $this->coordinate = $coordinate;
        $this->name = $name;
        $this->trafficLightValue = $trafficLightValue;
        $this->kilowattPower = $kilowattPower;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTrafficLightValue(): int
    {
        return $this->trafficLightValue;
    }

    public function getKilowattPower(): int
    {
        return $this->kilowattPower;
    }
}