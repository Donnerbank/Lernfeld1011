<?php

namespace Lernfeld1011\infrastructure\database;

use Lernfeld1011\models\SolarBank;
use PDO;

class SolarBankWriter
{
    private PDO $pdo;

    /** Writes Solar Banks in the DataBase */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(SolarBank $solarBank): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO solarbank 
        (name, longitude, latitude, trafficLightValue, kilowattPower, uuid) VALUES 
        (:name, :long, :lat, :value, :power, :uuid)');
        $stmt->bindValue('uuid', $solarBank->getUuid(), PDO::PARAM_STR);
        $this->bindValues($stmt, $solarBank);

        return $stmt->execute();
    }

    public function update(SolarBank $solarBank): bool
    {
        $stmt = $this->pdo->prepare('UPDATE solarbank SET
        name = :name,
        longitude = :long,
        latitude = :lat,
        trafficLightValue = :value,
        kilowattPower = :power WHERE uuid = "'.$solarBank->getUuid().'"');
        $this->bindValues($stmt, $solarBank);

        return $stmt->execute();
    }

    private function bindValues(bool|\PDOStatement $stmt, SolarBank $solarBank): void
    {
        $stmt->bindValue(':name', $solarBank->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':long', $solarBank->getCoordinate()->getLongitude(), PDO::PARAM_STR);
        $stmt->bindValue('lat', $solarBank->getCoordinate()->getLatitude(), PDO::PARAM_STR);
        $stmt->bindValue(':value', $solarBank->getTrafficLightValue(), PDO::PARAM_INT);
        $stmt->bindValue(':power', $solarBank->getKilowattPower(), PDO::PARAM_INT);
    }
}
