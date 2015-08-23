<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\Month;

use \DateTime;

class MonthFactory
{

    public function createMonthFromDatetime(DateTime $date)
    {
        $month = (int) $date->format('n');
        $year = (int) $date->format('Y');
        return $this->create($month, $year);
    }

    public function create($month, $year)
    {
        return new Month($month, $year);
    }
}
