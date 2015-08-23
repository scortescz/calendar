<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\Helpers;

use \DateTime;

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
    
    public function __construct()
    {
        $this->date = $this->getToday();
        $this->day = $this->getDay();
        $this->monthNumber = $this->getMonth();
        $this->year = $this->getYear();
        $this->weekNumber = $this->getWeek();
    }

    private function getToday()
    {
        return new DateTime();
    }

    private function getDay()
    {
        return $this->date->format('j');
    }

    private function getMonth()
    {
        return $this->date->format('n');
    }

    private function getYear()
    {
        return $this->date->format('Y');
    }

    private function getWeek()
    {
        return $this->date->format('W');
    }
}
