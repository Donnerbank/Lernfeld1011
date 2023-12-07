<?php

namespace unit;

use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\Date;
use Lernfeld1011\models\WeatherDataSet;
use Lernfeld1011\models\WeatherNode;
use PHPUnit\Framework\TestCase;

/** @covers \Lernfeld1011\models\WeatherNode
 *@covers \Lernfeld1011\models\WeatherDataSet
 */
class WeatherNodeTest extends TestCase
{
    public function testObjectCanBeCreated(): void
    {
        $coordinate = Coordinate::fromFloat(1.5, -2.5);
        $date = Date::createFromIntegers(1, 1, 1970);
        $this->assertInstanceOf(WeatherNode::class, new WeatherNode($coordinate, $date));
    }

    public function testWeatherNodeCanAddWeatherDataSet(): void
    {
        $coordinate = Coordinate::fromFloat(1.5, -2.5);
        $date = Date::createFromIntegers(1, 1, 1970);
        $node = new WeatherNode($coordinate, $date);
        $weatherDataSet = new WeatherDataSet(
            25,
            18.0,
            3.0,
            4.0,
            5.0,
            6.0
        );
        $node->addWeatherData($weatherDataSet);
        $weatherDataSets = $node->getHourlyWeatherData();
        $this->assertCount(1, $weatherDataSets);
        /** @var WeatherDataSet $weatherDataSet */
        $weatherDataSet = reset($weatherDataSets);
        $this->assertInstanceOf(WeatherDataSet::class, $weatherDataSet);
        $this->assertEquals(25, $weatherDataSet->getTime());
        $this->assertEquals(18.0, $weatherDataSet->getTemperature());
        $this->assertEquals(3.0, $weatherDataSet->getTerrestrialRadiation());
        $this->assertEquals(4.0, $weatherDataSet->getTerrestrialRadiationInstant());
        $this->assertEquals(5.0, $weatherDataSet->getUvIndex());
        $this->assertEquals(6.0, $weatherDataSet->getUvIndexClearSky());
    }
}
