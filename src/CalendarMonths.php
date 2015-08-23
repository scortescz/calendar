<?php

namespace Scortes\Calendar;

class CalendarMonths implements \IteratorAggregate
{
    /** @var array */
    private $months = array();

    public function __construct(array $months)
    {
        $this->months = $months;
    }

    public function getMonthsCount()
    {
        return count($this->months);
    }

    public function getFirstMonth()
    {
        return $this->months[0];
    }

    public function getLastMonth()
    {
        $monthsCount = $this->getMonthsCount();
        return $this->months[$monthsCount - 1];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->months);
    }
}
