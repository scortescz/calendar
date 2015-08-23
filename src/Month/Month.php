<?php

namespace Scortes\Calendar\Month;

use DateTime;

class Month
{
    /** @var int */
    public $year;
    /** @var int */
    public $monthNumber;

    public static function fromDatetime(DateTime $date)
    {
        $month = (int) $date->format('n');
        $year = (int) $date->format('Y');
        return new self($month, $year);
    }

    public function __construct($monthNumber, $year)
    {
        $this->monthNumber = $monthNumber;
        $this->year = $year;
    }
}
