<?php

namespace Scortes\Calendar\Month;

use \DateTime;

class CreateMonthsInterval
{
    /** @var \Scortes\Calendar\Month */
    private $firstMonth;
    /** @var \Scortes\Calendar\Month */
    private $lastMonth;
    /** @var int */
    private $yearDifference;
    /** @var array */
    private $months;

    private $analyzeMonth;

    public function __construct(AnalyzeMonth $a)
    {
        $this->analyzeMonth = $a;
    }

    public function __invoke(DateTime $startDate, DateTime $endDate)
    {
        $this->months = array();
        $this->firstMonth = Month::fromDatetime($startDate);
        $this->lastMonth = Month::fromDatetime($endDate);
        $this->calculateYearDifference();
        $this->loadMonths();
        return $this->months;
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
        $endMonth = $this->areMonthsFromSameYear() ? $this->lastMonth->monthNumber : 12;
        $this->addMonths($this->firstMonth->year, $startMonth, $endMonth);
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
            $m = new Month($month, $year);
            $this->analyzeMonth->__invoke($m);
            $this->months[] = $m;
        }
    }
}
