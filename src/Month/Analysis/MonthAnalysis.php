<?php

namespace Scortes\Calendar\Month\Analysis;

class MonthAnalysis
{
    /** @var int */
    public $daysCount;
    /** @var int */
    public $weeksCount;
    /** @var int */
    public $firstDayOfWeek;
    /** @var int */
    public $firstWeekNumber;

    public function __construct()
    {
        $this->daysCount = 0;
        $this->weeksCount = 0;
        $this->firstDayOfWeek = 0;
        $this->firstWeekNumber = 0;
    }
}
