<?php

namespace Lernfeld1011\infrastructure;

use Lernfeld1011\controllers\OpenMeteoApi;
use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\WeatherNode;

class OpenMeteoReader
{
    private OpenMeteoApi $meteoApi;

    /** OpenMeteoApi with working url */
    public function __construct(OpenMeteoApi $meteoApi)
    {
        $this->meteoApi = $meteoApi;
    }

    /** Link Format: https://api.open-meteo.com/v1/forecast?latitude=53.5507&longitude=9.993&hourly=temperature_2m,weathercode,cloudcover,uv_index,uv_index_clear_sky,terrestrial_radiation,terrestrial_radiation_instant&current_weather=true&timezone=Europe/Berlin&forecast_days=1 **/

    /** Request WeatherData from MeteoAPI. Retuns WeatherNode */
    public function getWeatherData(Coordinate $coordinate): WeatherNode
    {
        return $this->meteoApi->getData($coordinate);
    }

    /** Read Test JSON File */
    public function getWeatherDataFixture(): WeatherNode
    {
        $data = file_get_contents(__DIR__.'/../../testWeather.json');

        return $this->meteoApi->getMapper()->fromJSON($data);
    }
}
