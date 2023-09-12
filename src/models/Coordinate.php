<?php

namespace Lernfeld1011\models;
use InvalidArgumentException;

/**
 * Value Object to capture the longitude and latitude, 2 float values in one Object.
 */
class Coordinate
{
    private float $latitude;

    private float $longitude;

    /** Private Contructor. Use fromFloat() method. Easier to read for programmer. */
    private function __construct(float $latitude, float $longitude)
    {
        $this->ensureIsValid($longitude);
        $this->ensureIsValid($latitude);
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    /** Throws Exception if not valid */
    private function ensureIsValid(float $val): void
    {
        if (! self::isValid($val)) {
            throw new InvalidArgumentException(sprintf('Der Angegebene Wert %s passt nicht zu einer Koordinate', $val));
        }
    }

    /** We have no proper validation yet. So far we accept all floats.
     * This function exists in case we find limits we need to validate
     */
    public static function isValid(float $val): bool
    {
        if (! is_float($val)) {
            return false;
        }

        return true;
    }

    /** Method that creates the Object */
    public static function fromFloat(float $latitude, float $longitude)
    {
        return new self($latitude, $longitude);
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /** return a readable String of format Coordinate: {x.xxxxxx, y.yyyyyy} */
    public function getCoordinateAsString(): string
    {
        return 'Coordinate: {'.round($this->latitude, 6).', '.round($this->longitude, 6).'}';
    }
}
