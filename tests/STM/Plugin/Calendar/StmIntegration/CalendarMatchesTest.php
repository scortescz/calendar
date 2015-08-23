<?php

namespace STM\Plugin\Calendar\StmIntegration;

require_once(STM_BOOTSTRAP);

/**
 * @group stm_calendar
 */
class CalendarMatchesTest extends \PHPUnit_Framework_TestCase
{
    /** @var CalendarMatches */
    private $object;

    protected function setUp()
    {
        $loader = new Matches\MatchesLoaderMock();
        $this->object = new CalendarMatches($loader);
    }
    
    public function testEffectiveDateIs10()
    {
        parent::assertEquals(10, $this->object->getEffectiveDate());
    }

    public function testResponseIsNotLoaded()
    {
        parent::assertNull($this->object->getContent());
    }

    public function testCalendarResponseIsLoaded()
    {
        $this->setRequestAndLoadContent($this->getRequest());
        parent::assertTrue($this->object->getContent() instanceof \STM\Plugin\Calendar\CalendarResponse);
    }

    private function getRequest()
    {
        $request = new StmCalendarRequest();
        $request->dateDelimiter = '-';
        $request->dateFormat = 'Y-m-d';
        $request->dateMin = '2009-01-01';
        $request->dateMax = '2009-12-31';
        $request->matchSelection = array();
        return $request;
    }

    private function setRequestAndLoadContent(StmCalendarRequest $request)
    {
        $this->object->setRequest($request, array());
        $this->object->reloadContent();
    }

    public function testMonthsWithoutMatchAreNotDelete()
    {
        $this->assertLoadingMonths(false, 12);
    }

    public function testLoadingOnlyMonthsWithMatches()
    {
        $this->assertLoadingMonths(true, 1);
    }

    private function assertLoadingMonths($deleteBoundaryMonths, $expectedMonthsCount)
    {
        $request = $this->getRequest();
        $request->deleteBoundaryMonthsWithoutMatches = $deleteBoundaryMonths;
        $this->setRequestAndLoadContent($request);
        $calendarMonths = $this->object->getContent()->months;
        parent::assertEquals($expectedMonthsCount, $calendarMonths->getMonthsCount());
    }
}
