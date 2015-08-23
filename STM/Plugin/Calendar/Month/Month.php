<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\Month;

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
