<?php

namespace Lernfeld1011\models;

class DateTime extends \DateTime
{
    public static function createFromIntegers(int $day, int $month, int $year): \DateTime
    {
        $date = self::createFromFormat('Y-m-d H:i:s', $year.'-'.$month.'-'.$day.' 00:00:00');
        if (! $date) {
            throw new \InvalidArgumentException('Falsches Datum');
        }

        return $date;
    }

    public static function createFromExternFormat(string $time): \DateTime
    {
        $date = date('Y-m-d H:i:s', strtotime($time));
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $date);
        if (! $dateTime) {
            throw new \InvalidArgumentException('Falsches Datum');
        }

        return $dateTime;
    }
}
