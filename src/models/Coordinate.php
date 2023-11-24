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
        $this->ensureIsValid($longitude, $latitude);
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    /** Throws Exception if not valid */
    private function ensureIsValid(float $long, float $lat): void
    {
        if (! self::isValid($long, $lat)) {
            throw new InvalidArgumentException(sprintf('Longitude must be between 180 and - 180, currently is: %s \n Latitude must be between 90 and -90, currently is: %s', $long,$lat));
        }
    }

    /** We have no proper validation yet. So far we accept all floats.
     * This function exists in case we find limits we need to validate
     */
    public static function isValid(float $long, float $lat): bool
    {
        // TODO: Max und Min
        if ($long > 180 || $long < -180) {
            return false;
        }
        if ($lat > 90 || $lat < -90) {
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
