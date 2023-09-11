<?php

namespace Lernfeld1011\models;

class Date
{
    private int $day;

    private int $month;

    private int $year;

    private function __construct(int $day, int $month, int $year)
    {
        $this->ensureIsValid($day, $month, $year);
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public static function createFromIntegers(int $day, int $month, int $year): self
    {
        return new self($day, $month, $year);
    }

    // Vielleicht createFromFormatDMY()

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
