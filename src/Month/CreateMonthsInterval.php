<?php

namespace Scortes\Calendar\Month;

use \DateTime;

class CreateMonthsInterval
{
    /** @var \Scortes\Calendar\Month */
    private $firstMonth;
    /** @var \Scortes\Calendar\Month */
    private $lastMonth;
    /** @var bool */
    private $areMonthsFromSameYear;
    /** @var bool */
    private $existCompleteYearBetweenMonths;
    /** @var array */
    private $months;

    private $analyzeMonth;

    public function __construct(AnalyzeMonth $a)
    {
        $this->analyzeMonth = $a;
    }

    public function __invoke(DateTime $startDate, DateTime $endDate)
    {
        $this->months = [];
        $this->firstMonth = $this->monthFromDatetime($startDate);
        $this->lastMonth = $this->monthFromDatetime($endDate);
        $this->analyzeYearDifference();
        $this->loadMonths();
        return $this->months;
    }

    private function monthFromDatetime(DateTime $date)
    {
        $month = (int) $date->format('n');
        $year = (int) $date->format('Y');
        return new Month($month, $year);
    }

    private function analyzeYearDifference()
    {
        $yearDifference = $this->lastMonth->year - $this->firstMonth->year;
        $this->areMonthsFromSameYear = $yearDifference == 0;
        $this->existCompleteYearBetweenMonths = $yearDifference >= 2;
    }

    private function loadMonths()
    {
        $this->addMonthsFromFirstYear();
        if ($this->existCompleteYearBetweenMonths) {
            $this->addMonthsFromBetweenYears();
        }
        if (!$this->areMonthsFromSameYear) {
            $this->addMonthsFromLastYear();
        }
    }

    private function addMonthsFromFirstYear()
    {
        $startMonth = $this->firstMonth->monthNumber;
        $endMonth = $this->areMonthsFromSameYear ? $this->lastMonth->monthNumber : 12;
        $this->addMonths($this->firstMonth->year, $startMonth, $endMonth);
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
