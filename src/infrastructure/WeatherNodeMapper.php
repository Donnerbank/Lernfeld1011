<?php

namespace infrastructure;

use Coordinate;
use Lernfeld1011\infrastructure\Factory;
use WeatherDataSet;
use WeatherNode;

class WeatherNodeMapper
{
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /** based on weatherAPI formate */
    public function fromArray(array $arr): WeatherNode
    {
        $long = 0;
        $lat = 0;
        $date = 'Doomsday';
        //TODO date
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
        $weatherNode = new WeatherNode($coordinate, $date);
        if (! empty($arr['hourly'])) {
            $index = 0;
            $hourData = $arr['hourly'];
            $timeData = array_values($hourData['time']);
            $tempData = array_values($hourData['temperature_2m']);
            $trData = array_values($hourData['terrestrial_radiation']);
            $triData = array_values($hourData['terrestrial_radiation_instant']);
            $uvIndexData = array_values($hourData['uv_index']);
            $uvICSData = array_values($hourData['uv_index_clear_sky']);
            while ($index < 24) {
                $weatherDataSet = new WeatherDataSet(
                    $timeData[$index] ?? 0,
                    $tempData[$index] ?? -273.15,
                    $trData[$index] ?? 0.0,
                    $triData[$index] ?? 0.0,
                    $uvIndexData[$index] ?? 0.0,
                    $uvICSData[$index] ?? 0.0
                );
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

    public function toArray(WeatherNode $weatherNode): array
    {
        $weatherData = [];
        $arr = [];
        $index = 0;
        foreach ($weatherNode->getHourlyWeatherData() as $time => $dataSet) {
            $weatherData[$index]['time'] = $time;
            $weatherData[$index]['temperature'] = $dataSet->getTemperature();
            $weatherData[$index]['terrestrialRadiation'] = $dataSet->getTerrestrialRadiation();
            $weatherData[$index]['terrestrialRadiationInstant'] = $dataSet->getTerrestrialRadiationInstant();
            $weatherData[$index]['uvIndex'] = $dataSet->getUvIndex();
            $weatherData[$index]['uvIndexClearSky'] = $dataSet->getUvIndexClearSky();
            $index++;
        }
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
