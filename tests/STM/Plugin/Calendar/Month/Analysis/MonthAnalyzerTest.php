<?php

namespace STM\Plugin\Calendar\Month\Analysis;

use STM\Plugin\Calendar\Month\Month;

/**
 * @group analysis
 */
class MonthAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /** @var MonthAnalyzer */
    private $analyzer;

    protected function setUp()
    {
        $this->analyzer = new MonthAnalyzer;
    }

    public function testSeptember2013Has30DaysAnd6WeeksAndStartsOnSundayIn35thWeek()
    {
        $month = $this->createMonth(9, 2013);
        $this->assertAnalysis($month, 30, 6, 7, 35);
    }

    public function testSeptember2014Has30DaysAnd5WeeksAndStartsOnMondayIn36thWeek()
    {
        $month = $this->createMonth(9, 2014);
        $this->assertAnalysis($month, 30, 5, 1, 36);
    }

    public function testJanuary2014Has31DaysAnd5WeeksAndStartsOnWednesdayIn1stWeek()
    {
        $month = $this->createMonth(1, 2014);
        $this->assertAnalysis($month, 31, 5, 3, 1);
    }

    private function assertAnalysis(Month $month, $days, $weeks, $firstDay, $firstWeekNumber)
    {
        $analysis = $this->analyzer->analyze($month);
        parent::assertEquals($days, $analysis->daysCount);
        parent::assertEquals($weeks, $analysis->weeksCount);
        parent::assertEquals($firstDay, $analysis->firstDayOfWeek);
        parent::assertEquals($firstWeekNumber, $analysis->firstWeekNumber);
    }

    private function createMonth($month, $year)
    {
        return new Month($month, $year);
    }
}
