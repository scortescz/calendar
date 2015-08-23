<?php

namespace Scortes\Calendar;

use \DateTime;
use Scortes\Calendar\Month\Month;

class Today
{
    /** @var \DateTime */
    public $date;
    /** @var int */
    public $day;
    /** @var int */
    public $monthNumber;
    /** @var int */
    public $year;
    /** @var int */
    public $weekNumber;
    
    public function __construct(DateTime $d = null)
    {
        $this->date = $d ?: new DateTime();
        $this->day = $this->extract('j');
        $this->monthNumber = $this->extract('n');
        $this->year = $this->extract('Y');
        $this->weekNumber = $this->extract('W');
    }

    private function extract($format)
    {
        return (int) $this->date->format($format);
    }

    public function isCurrentMonth(Month $month)
    {
        return $this->monthNumber == $month->monthNumber && $this->year == $month->year;
    }

    public function isCurrentWeek(Month $month, $weekNumber)
    {
        return $this->weekNumber == ($month->firstWeekNumber + $weekNumber);
    }

    public function isCurrentDay(Month $month, $weekDay, $currentDay)
    {
        $isDayInMonth = $weekDay >= $month->firstDayOfWeek && $currentDay <= $month->daysCount;
        $isCurrentDay = $this->day == $currentDay;
        return array($isDayInMonth, $isCurrentDay);
    }
}
