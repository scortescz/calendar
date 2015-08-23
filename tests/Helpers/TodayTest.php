<?php

namespace Scortes\Calendar\Helpers;

use \DateTime;

/**
 * @group helpers
 */
class TodayTest extends \PHPUnit_Framework_TestCase
{
    /** @var Today */
    private $today;

    protected function setUp()
    {
        $this->today = new Today();
    }

    public function testDateTimeIsReturned()
    {
        parent::assertTrue($this->today->date instanceof DateTime);
    }

    public function testNoDifferenceBetweenCurrentDayAndDate()
    {
        $difference = $this->today->day - date('j');
        parent::assertEquals(0, $difference);
    }

    public function testNoDifferenceBetweenCurrentMonthAndDate()
    {
        $difference = $this->today->monthNumber - date('n');
        parent::assertEquals(0, $difference);
    }

    public function testNoDifferenceBetweenCurrentYearAndDate()
    {
        $difference = $this->today->year - date('Y');
        parent::assertEquals(0, $difference);
    }

    public function testNoDifferenceBetweenCurrentWeekAndDate()
    {
        $difference = $this->today->weekNumber - date('W');
        parent::assertEquals(0, $difference);
    }
}
