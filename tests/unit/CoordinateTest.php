<?php

namespace unit;

use Exception;
use Lernfeld1011\models\Coordinate;
use PHPUnit\Framework\TestCase;

/** @covers \Lernfeld1011\models\Coordinate */
class CoordinateTest extends TestCase
{
    public function testObjectCanBeCreated(): void
    {
        $this->assertInstanceOf(Coordinate::class, Coordinate::fromFloat(1.0, 1.0));
    }

    public function testFloatValues(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $lat = rand(-9000, 9000) / 100;
            $long = rand(-18000, 18000) / 100;
            $coordinate = Coordinate::fromFloat($lat, $long);
            $this->assertIsFloat($coordinate->getLatitude());
            $this->assertIsFloat($coordinate->getLongitude());
            $this->assertEquals($lat, $coordinate->getLatitude());
            $this->assertEquals($long, $coordinate->getLongitude());
        }
    }

    public function testLatitudeAndLongitudeLimit(): void
    {
        $this->expectException(Exception::class);
        Coordinate::fromFloat(90.0, 180.1);
        $this->expectException(Exception::class);
        Coordinate::fromFloat(-90.0, -180.1);
        $this->expectException(Exception::class);
        Coordinate::fromFloat(91.0, 180.0);
        $this->expectException(Exception::class);
        Coordinate::fromFloat(-91.0, 180.0);
    }
}
