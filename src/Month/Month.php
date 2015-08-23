<?php

namespace Scortes\Calendar\Month;

class Month
{
    /** @var int */
    public $year;
    /** @var int */
    public $monthNumber;

    /** @var int */
    public $daysCount = 0;
    /** @var int */
    public $weeksCount = 0;
    /** @var int */
    public $firstDayOfWeek = 0;
    /** @var int */
    public $firstWeekNumber = 0;

    public function __construct($monthNumber, $year)
    {
        $this->monthNumber = $monthNumber;
        $this->year = $year;
    }
}
