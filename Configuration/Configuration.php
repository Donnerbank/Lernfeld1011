<?php

/**
 * Base Configuration
 */
class Configuration
{
    public function getRouterBase(): string
    {
        return '/Lernfeld1011/src/web';
    }

    /*
     * Future: Database Connections via PDO
     * PDO (PHP-Data Objects) interface that connects PHP and MySQL
     */

    public function meteoApiUrl(): string
    {
        return 'https://api.open-meteo.com/v1/forecast?latitude=%s&longitude=%s&hourly=temperature_2m,weathercode,cloudcover,uv_index,uv_index_clear_sky,terrestrial_radiation,terrestrial_radiation_instant&current_weather=true&timezone=Europe/Berlin&forecast_days=1';
    }

    public function getLocalDsn(): string
    {
        return 'mysql:host=localhost:3306;dbname=' . $this->getDbName();
    }

    public function getDbName(): string
    {
        return 'lernfeld1011';
    }

    public function getLocalUser(): string
    {
        return 'root';
    }

    public function getLocalPass(): string
    {
        return '';
    }
}
