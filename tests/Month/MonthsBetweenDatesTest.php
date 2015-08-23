<?php

namespace Scortes\Calendar\Month;

use \DateTime;

class MonthsBetweenDatesTest extends \PHPUnit_Framework_TestCase
{
    /** @var MonthsBetweenDatesDates */
    private $object;

    protected function setUp()
    {
        $factory = new MonthFactory();
        $this->object = new MonthsBetweenDates($factory);
    }

    public function testTwoMonthsBetweenOctoberAndNovember()
    {
        $start = $this->createDate(10, 2013);
        $end = $this->createDate(11, 2013);
        $this->assertNumberOfMonths(2, $start, $end);
    }

    public function testTwoMonthsBetweenDecemberAndJanuary()
    {
        $start = $this->createDate(12, 2013);
        $end = $this->createDate(1, 2014);
        $this->assertNumberOfMonths(2, $start, $end);
    }

    public function testOneMonthBetweenDatesFromSameMonth()
    {
        $start = $this->createDate(1, 2014);
        $end = $this->createDate(1, 2014);
        $this->assertNumberOfMonths(1, $start, $end);
    }

    public function test36monthsBetweenJanuary2013andDecember2015()
    {
        $start = $this->createDate(1, 2013);
        $end = $this->createDate(12, 2015);
        $this->assertNumberOfMonths(36, $start, $end);
    }

    private function assertNumberOfMonths($expectedMonthsCount, $start, $end)
    {
        $months = $this->object->getMonths($start, $end);
        parent::assertEquals($expectedMonthsCount, count($months));
    }

    public function testMarchIsBetweenFebruaryAndApril()
    {
        $start = $this->createDate(2, 2013);
        $end = $this->createDate(4, 2013);

        $months = $this->object->getMonths($start, $end);
        $march = $months[1];

        parent::assertEquals(3, $march->monthNumber);
        parent::assertEquals(2013, $march->year);
    }

    private function createDate($month, $year)
    {
        return DateTime::createFromFormat('n/Y', "{$month}/{$year}");
    }
}
