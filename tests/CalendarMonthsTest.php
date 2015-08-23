<?php

namespace Scortes\Calendar;

/**
 * @group calendar
 */
class CalendarMonthsTest extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    private $inputMonths;
    /** @var Months */
    private $months;

    protected function setUp()
    {
        $this->inputMonths = array(1, 2, 3);
        $this->months = new CalendarMonths($this->inputMonths);
    }

    public function testThreeMonths()
    {
        parent::assertEquals(3, $this->months->getMonthsCount());
    }

    public function testFirstMonthIsNumberOne()
    {
        parent::assertEquals(1, $this->months->getFirstMonth());
    }

    public function testLastMonthIsNumberThree()
    {
        parent::assertEquals(3, $this->months->getLastMonth());
    }

    public function testIterator()
    {
        $array = iterator_to_array($this->months);
        parent::assertEquals(3, count($array));
        parent::assertEquals($this->inputMonths, $array);
    }
}
