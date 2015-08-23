<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\Month\Analysis;

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
