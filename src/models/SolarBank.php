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

    public function __construct(Coordinate $coordinate, string $name, int $trafficLightValue, int $kilowattPower, string $uuid)
    {
        $this->coordinate = $coordinate;
        $this->name = $name;
        $this->trafficLightValue = $trafficLightValue;
        $this->kilowattPower = $kilowattPower;
        if(!empty($uuid))
            $this->uuid = $uuid;
        else
            $this->uuid = $this->generateUuid();
    }

    private function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10
        return vsprintf('%s%sB-%sA-%sN-%sA-%sN%sA%s', str_split(bin2hex($data), 4));
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

    public function getUuid(): string
    {
        return $this->uuid;
    }

}
