<?php

namespace Scortes\Calendar\Month;

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
