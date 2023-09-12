<?php

namespace Lernfeld1011\models;

/** Value Object for Date. We want this over a string, so we don't have to deal with formatting (d.m.Y. or m-d-y ...) */
class Date
{
    private int $day;

    private int $month;

    private int $year;

    /** private Contructor */
    private function __construct(int $day, int $month, int $year)
    {
        $this->ensureIsValid($day, $month, $year);
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    /** public method that creates the Object from 3 integers */
    public static function createFromIntegers(int $day, int $month, int $year): self
    {
        return new self($day, $month, $year);
    }

    /** Throws exception if not valid.
     * We use the DateTime Object from PHP to verify if the given Date is valid.
     * DateTime::createFromFormat() returns false if the Date is incorrect.
     */
    private function ensureIsValid(int $day, int $month, int $year): void
    {
        $dateTime = \DateTime::createFromFormat('d.m.Y', $day.'.'.$month.'.'.$year);
        if (! $dateTime) {
            throw new \Exception('Invalid Date');
        }
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
