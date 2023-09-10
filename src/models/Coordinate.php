<?php

class Coordinate
{

    private float $latitude;
    private float $longitude;

    private function __construct(float $latitude,float $longitude)
    {
        $this->ensureIsValid($longitude);
        $this->ensureIsValid($latitude);
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    private function ensureIsValid(float $val):void
    {
        if(!self::isValid($val))
            throw new InvalidArgumentException(sprintf('Der Angegebene Wert %s passt nicht zu einer Koordinate', $val));
    }

    public static function isValid(float $val): bool
    {
        if(!is_float($val)) return false;
        return true;
    }

    public static function fromFloat(float $latitude, float $longitude)
    {
        return new self($latitude,$longitude);
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getCoordinateAsString(): string
    {
        return 'Coordinate: {' . round($this->latitude,6) . ', ' . round($this->longitude,6) . '}';
    }
}