<?php

namespace Lernfeld1011\infrastructure\database;

use Lernfeld1011\infrastructure\SolarBankMapper;
use Lernfeld1011\models\Coordinate;
use Lernfeld1011\models\SolarBank;
use Lernfeld1011\models\SolarBankUUID;
use PDO;

class SolarBankReader
{
    private PDO $pdo;

    private SolarBankMapper $mapper;

    /** Reads Data from the DataBase. returns a SolarBank Object */
    public function __construct(PDO $pdo, SolarbankMapper $mapper)
    {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    public function readById(int $id): SolarBank
    {
        $stmt = $this->pdo->prepare('SELECT * FROM solarbank WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->mapper->fromArray($stmt->fetch());
    }

    public function readByUuid(SolarBankUUID $uuid): SolarBank
    {
        $stmt = $this->pdo->prepare('SELECT * FROM solarbank WHERE uuid = :uuid LIMIT 1');
        $stmt->bindValue(':uuid', $uuid->asString(), PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        if (! $row) {
            throw new \InvalidArgumentException('UUID not found ('.$uuid->asString().').');
        }

        return $this->mapper->fromArray($row);
    }

    public function readByCoordinates(Coordinate $coordinate): SolarBank
    {
        $stmt = $this->pdo->prepare('SELECT * FROM solarbank WHERE longitude = :long AND latitude = :lat LIMIT 1');
        $stmt->bindValue(':long', $coordinate->getLongitude(), PDO::PARAM_STR);
        $stmt->bindValue(':lat', $coordinate->getLatitude(), PDO::PARAM_STR);
        $stmt->execute();

        return $this->mapper->fromArray($stmt->fetch());
    }

    public function readByName(string $name): SolarBank
    {
        $stmt = $this->pdo->prepare('SELECT * FROM solarbank WHERE name = :name LIMIT 1');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        return $this->mapper->fromArray($stmt->fetch());
    }

    /** Reads all SolarBanks
     * @return array<SolarBank>
     */
    public function readAll(): array
    {
        $array = [];
        $stmt = $this->pdo->prepare('SELECT * FROM solarbank WHERE deleted = 0');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $array[] = $this->mapper->fromArray($row);
        }

        return $array;
    }
}
