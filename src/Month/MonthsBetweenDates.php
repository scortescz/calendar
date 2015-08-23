<?php

namespace Scortes\Calendar\Month;

use \DateTime;

class MonthsBetweenDates
{
    /** @var \Scortes\Calendar\Month */
    private $firstMonth;
    /** @var \Scortes\Calendar\Month */
    private $lastMonth;
    /** @var int */
    private $yearDifference;
    /** @var array */
    private $months;

    public function getMonths(DateTime $startDate, DateTime $endDate)
    {
        $this->months = array();
        $this->setFirstMonth($startDate);
        $this->setLastMonth($endDate);
        $this->calculateYearDifference();
        $this->loadMonths();
        return $this->months;
    }

    private function setFirstMonth($startDate)
    {
        $this->firstMonth = Month::fromDatetime($startDate);
    }

    private function setLastMonth($endDate)
    {
        $this->lastMonth = Month::fromDatetime($endDate);
    }

    private function calculateYearDifference()
    {
        $this->yearDifference = $this->lastMonth->year - $this->firstMonth->year;
    }

    private function loadMonths()
    {
        $this->addMonthsFromFirstYear();
        if ($this->existCompleteYearBetweenMonths()) {
            $this->addMonthsFromBetweenYears();
        }
        if (!$this->areMonthsFromSameYear()) {
            $this->addMonthsFromLastYear();
        }
    }

    private function addMonthsFromFirstYear()
    {
        $startMonth = $this->firstMonth->monthNumber;
        $endMonth = $this->getEndMonthForFirstYear();
        $this->addMonths($this->firstMonth->year, $startMonth, $endMonth);
    }

    private function getEndMonthForFirstYear()
    {
        if ($this->areMonthsFromSameYear()) {
            return $this->lastMonth->monthNumber;
        }
        return 12;
    }

    private function areMonthsFromSameYear()
    {
        return $this->yearDifference == 0;
    }

    private function existCompleteYearBetweenMonths()
    {
        return $this->yearDifference >= 2;
    }

    private function addMonthsFromBetweenYears()
    {
        for ($year = $this->firstMonth->year + 1; $year < $this->lastMonth->year; $year++) {
            $this->addMonths($year, 1, 12);
        }
    }

    private function addMonthsFromLastYear()
    {
        $this->addMonths($this->lastMonth->year, 1, $this->lastMonth->monthNumber);
    }

    private function addMonths($year, $startMonth, $endMonth)
    {
        for ($month = $startMonth; $month <= $endMonth; $month++) {
            $this->months[] = new Month($month, $year);
        }
    }
}
