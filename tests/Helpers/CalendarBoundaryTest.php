<?php

namespace Scortes\Calendar\Helpers;

use Scortes\Calendar\Month\Month;
use Scortes\Calendar\Events\Events;

class CalendarBoundaryTest extends \PHPUnit_Framework_TestCase
{
    /** @var CalendarBoundary */
    private $object;

    protected function setUp()
    {
        $this->object = new CalendarBoundary();
    }

    public function testNoMonths()
    {
        $this->setEvents('-', array());
        $this->assertMonthsCountIn2009(0);
    }

    public function testDeleteFirstMonths()
    {
        $this->setEvents('-', array('2009-12-10'));
        $this->assertMonthsCountIn2009(1);
    }

    public function testDeleteLastMonths()
    {
        $this->setEvents('-', array('2009-1-10'));
        $this->assertMonthsCountIn2009(1);
    }

    public function testDeleteFirstAndLastMonth()
    {
        $this->setEvents('-', array('2009-8-10', '2009-11-11'));
        $this->assertMonthsCountIn2009(4);
    }

    private function setEvents($delimiter, array $events)
    {
        $e = new Events($delimiter);
        foreach ($events as $event) {
            $e->set($event, $event);
        }
        $this->object->setEvents($e);
    }

    private function assertMonthsCountIn2009($expectedCount)
    {
        $months = $this->getMonths(2009, 1, 12);
        $delete = $this->object->deleteBoundaryMonthsWithoutEvents($months);
        parent::assertEquals($expectedCount, count($delete));
    }

    private function getMonths($year, $startMonth, $endMonth)
    {
        $months = array();
        for ($m = $startMonth; $m <= $endMonth; $m++) {
            $months[] = new Month($m, $year);
        }
        return $months;
    }
}
