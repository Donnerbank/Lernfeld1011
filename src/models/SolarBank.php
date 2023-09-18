<?php

namespace Lernfeld1011\models;

/** Our Model for containing and working with the SolarBank data. */
class SolarBank
{
    /** @var Coordinate Contains the geographical coordinates */
    private Coordinate $coordinate;

    private string $name;

    /** @var int a value that indicates how active this Solar Bank is. (1-4) */
    private int $trafficLightValue;

    /** @var int Average Power that can be used to charge phones */
    private int $kilowattPower;

    private string $uuid;
    // Till sagt UUID value Object. Wird nach außen übergeben um die Solar Bank in der Datenbank anzusprechen

    public function __construct(Coordinate $coordinate, string $name, int $trafficLightValue, int $kilowattPower)
    {
        $this->uuid = uniqid();
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
