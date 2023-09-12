<?php

namespace Lernfeld1011\infrastructure;


use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\Date;
use Lernfeld1011\models\WeatherDataSet;
use Lernfeld1011\models\WeatherNode;
/**
 * Maps an array or a json string to a WeatherNode Object and vice versa.
 * Expects the json from the extern WeatherAPI and translates them.
 */
class WeatherNodeMapper
{
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /** expects array with keys based on the extern WeatherAPI */
    public function fromArray(array $arr): WeatherNode
    {
        // initializing default values
        $long = 0;
        $lat = 0;
        // timestamp = 0
        $date = Date::createFromIntegers(1,1,1970);

        // extracting and checking array values
        if (! empty($arr['longitude'])) {
            $long = floatval($arr['longitude']);
        }
        if (! empty($arr['latitude'])) {
            $lat = floatval($arr['latitude']);
        }
        if (! empty($arr['date'])) {
            $date = $arr['date'];
        }
        $coordinate = Coordinate::fromFloat($lat, $long);
        // create a new WeatherNode. This one has no WeatherData yet.
        $weatherNode = $this->factory->createWeatherNode($coordinate,$date);

        if (! empty($arr['hourly'])) {
            $index = 0;
            // uses the hourly array with sub-arrays
            $hourData = $arr['hourly'];
            // extract all the sub-arrays with the needed data
            // use array_values to assign index values as keys.
            // Now these can all be accessed via an index to indiacte the data for a certain hour of the day
            $timeData = array_values($hourData['time']);
            $tempData = array_values($hourData['temperature_2m']);
            $trData = array_values($hourData['terrestrial_radiation']);
            $triData = array_values($hourData['terrestrial_radiation_instant']);
            $uvIndexData = array_values($hourData['uv_index']);
            $uvICSData = array_values($hourData['uv_index_clear_sky']);
            // Index represents hour of the day (0-23)
            while ($index < 24) {
                // Creates a WeatherDataSet. Uses a default if the value at $index is not set.
                $weatherDataSet = $this->factory->createWeatherDataSet(
                    $timeData[$index] ?? 0,
                    $tempData[$index] ?? -273.15,
                    $trData[$index] ?? 0.0,
                    $triData[$index] ?? 0.0,
                    $uvIndexData[$index] ?? 0.0,
                    $uvICSData[$index] ?? 0.0
                );
                // Adds the WeatherDataSet to the WeatherNode
                $weatherNode->addWeatherData($weatherDataSet);
                $index++;
            }
        }

        return $weatherNode;
    }

    public function fromJSON(string $json): WeatherNode
    {
        return $this->fromArray(json_decode($json, true));
    }

    /** Extracts the WeatherNodes' Data into an array */
    public function toArray(WeatherNode $weatherNode): array
    {
        $weatherData = [];
        $arr = [];
        // Index is going to be the hour of the day (0-23)
        $index = 0;
        foreach ($weatherNode->getHourlyWeatherData() as $time => $dataSet) {
            // adds a sub-array to the main array with the hourly weather data. The key is the hour of the day.
            $weatherData[$index]['time'] = $time;
            $weatherData[$index]['temperature'] = $dataSet->getTemperature();
            $weatherData[$index]['terrestrialRadiation'] = $dataSet->getTerrestrialRadiation();
            $weatherData[$index]['terrestrialRadiationInstant'] = $dataSet->getTerrestrialRadiationInstant();
            $weatherData[$index]['uvIndex'] = $dataSet->getUvIndex();
            $weatherData[$index]['uvIndexClearSky'] = $dataSet->getUvIndexClearSky();
            $index++;
        }
        // assign the above constructed array as sub-array
        $arr['hourlyWeatherData'] = $weatherData;
        $arr['longitude'] = $weatherNode->getCoordinate()->getLongitude();
        $arr['long'] = $weatherNode->getCoordinate()->getLongitude();
        $arr['latitude'] = $weatherNode->getCoordinate()->getLatitude();
        $arr['lat'] = $weatherNode->getCoordinate()->getLatitude();
        $arr['coordinate'] = $weatherNode->getCoordinate()->getCoordinateAsString();

        return $arr;
    }

    public function toJSON(WeatherNode $weatherNode): string
    {
        return json_encode($this->toArray($weatherNode));
    }
}
