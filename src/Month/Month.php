<?php

namespace Scortes\Calendar\Month;

class Month
{
    /** @var int */
    public $year;
    /** @var int */
    public $monthNumber;

    public function __construct($monthNumber, $year)
    {
        $this->monthNumber = $monthNumber;
        $this->year = $year;
    }
}
