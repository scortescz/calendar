<?php

namespace Scortes\Calendar;

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
        $this->date = new DateTime();
        $this->day = $this->extract('j');
        $this->monthNumber = $this->extract('n');
        $this->year = $this->extract('Y');
        $this->weekNumber = $this->extract('W');
    }

    private function extract($format)
    {
        return (int) $this->date->format($format);
    }
}
