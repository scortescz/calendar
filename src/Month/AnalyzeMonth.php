<?php

namespace Scortes\Calendar\Month;

use \DateTime;
use Scortes\Calendar\Month\Month;

class AnalyzeMonth
{
    private static $englishMonths = [
        '', 'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];
    /** @var \DateTime */
    private $firstDay;
    /** @var \DateTime */
    private $lastDay;

    public function __invoke(Month $month)
    {
        $this->loadDays($month);
        $month->daysCount = $this->getDaysCount();
        $month->weeksCount = $this->getWeeksCount();
        $month->firstDayOfWeek = $this->getWeekDayNumber();
        $month->firstWeekNumber = $this->getFirstWeekNumber();
    }

    private function loadDays($month)
    {
        $monthName = self::$englishMonths[$month->monthNumber];
        $this->firstDay = new DateTime("first day of {$monthName} {$month->year}");
        $this->lastDay = new DateTime("last day of {$monthName} {$month->year}");
    }

    private function getDaysCount()
    {
        return $this->lastDay->format('d');
    }

    private function getWeeksCount()
    {
        $weeksCount = 1;
        $totalDaysCount = $this->getDaysCount();
        $daysCount = $this->getDaysCountInFirstWeek();
        while ($daysCount < $totalDaysCount) {
            $weeksCount++;
            $daysCount += 7;
        }
        return $weeksCount;
    }

    private function getDaysCountInFirstWeek()
    {
        return 8 - $this->getWeekDayNumber();
    }

    private function getWeekDayNumber()
    {
        $weekday = (int) $this->firstDay->format('w');
        return $weekday == 0 ? 7 : $weekday;
    }

    private function getFirstWeekNumber()
    {
        return (int) $this->firstDay->format('W');
    }
}
