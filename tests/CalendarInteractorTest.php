<?php

namespace Scortes\Calendar;

use \DateTime;

class CalendarInteractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var CalendarInteractor */
    private $interactor;
    /** @var CalendarAsserts */
    private $asserts;
    /** @var CalendarResponse */
    private $response;

    protected function setUp()
    {
        $this->interactor = new CalendarInteractor();
        $this->asserts = new CalendarAsserts();
    }

    public function testThreeMonthsFromYearWithoutMissingMonth()
    {
        $expectations = array(
            'monthsCount' => 3,
            'firstMonth' => array('m' => 2, 'y' => 2013),
            'lastMonth' => array('m' => 4, 'y' => 2013)
        );
        $this->assertCalendarDates('01.02.2013', '18.04.2013', $expectations);
    }

    public function testCompleteYear()
    {
        $expectations = array(
            'monthsCount' => 12,
            'firstMonth' => array('m' => 1, 'y' => 2013),
            'lastMonth' => array('m' => 12, 'y' => 2013)
        );
        $this->assertCalendarDates('01.01.2013', '18.12.2013', $expectations);
    }

    public function testTwoMonthsInDifferentYears()
    {
        $expectations = array(
            'monthsCount' => 2,
            'firstMonth' => array('m' => 12, 'y' => 2013),
            'lastMonth' => array('m' => 1, 'y' => 2014)
        );
        $this->assertCalendarDates('08.12.2013', '02.01.2014', $expectations);
    }

    public function testMonthsFromThreeYears()
    {
        $expectations = array(
            'monthsCount' => 19,
            'firstMonth' => array('m' => 8, 'y' => 2013),
            'lastMonth' => array('m' => 2, 'y' => 2015)
        );
        $this->assertCalendarDates('08.08.2013', '02.02.2015', $expectations);
    }

    private function assertCalendarDates($startDate, $endDate, array $expectations)
    {
        $request = $this->getMonthsRequest($startDate, $endDate);
        $this->assertCalendarRequest($request, $expectations);
    }

    private function assertCalendarRequest(CalendarRequest $request, array $expectations)
    {
        $this->response = $this->interactor->__invoke($request);
        $this->asserts->setCalendarResponse($this->response);
        $this->asserts->assertFirstMonthInCalendar($expectations['firstMonth']['m'], $expectations['firstMonth']['y']);
        $this->asserts->assertLastMonthInCalendar($expectations['lastMonth']['m'], $expectations['lastMonth']['y']);
        $this->asserts->assertNumberOfMonthsInCalendar($expectations['monthsCount']);
    }

    private function getMonthsRequest($startDate, $endDate)
    {
        $request = new CalendarRequest();
        $request->dateStart = $this->getDateTime($startDate);
        $request->dateEnd = $this->getDateTime($endDate);
        return $request;
    }

    private function getDateTime($date)
    {
        return DateTime::createFromFormat('d.m.Y', $date);
    }

    public function testBasicEvents()
    {
        $events = array(
            '2013-9-5' => 'Shopping',
            '2013-10-6' => 'School exam',
            '2013-10-30' => 'Vacations'
        );
        $this->loadEventsResponse($events, '-');
        $this->asserts->assertExistingEvent('2013-10-30', 'Vacations');
        $this->asserts->assertExistingEventsFromIterator(
            '2013-10',
            array(
                '2013-10-6' => 'School exam',
                '2013-10-30' => 'Vacations'
            )
        );
    }

    public function testDupliciteEvents()
    {
        // actually events are passed in array and array key must be unique,
        // so duplicite events must be in array, otherwise only last event with key will be processed
        $events = array(
            '5.9.2013' => array('Shopping', 'Vacations')
        );
        $this->loadEventsResponse($events, '.');
        $event = $this->response->events->getEvent('5.9.2013');
        parent::assertEquals(array('Shopping', 'Vacations'), $event);
    }

    private function loadEventsResponse(array $events, $delimiter)
    {
        $request = $this->getEventsRequest($events, $delimiter);
        $this->response = $this->interactor->__invoke($request);
        $this->asserts->setCalendarResponse($this->response);
    }

    private function getEventsRequest(array $events, $delimiter)
    {
        $request = new CalendarRequest();
        $request->dateStart = new DateTime('now');
        $request->dateEnd = new DateTime('now');
        $request->events = $events;
        $request->eventsDelimiter = $delimiter;
        return $request;
    }

    public function testAnalyzeSeptember2013()
    {
        $this->loadAnalyzerResponse('2013-09-01', '2013-09-30');
        $this->assertNumberOfAnalyzedMonths(1);
        
        $september2013 = $this->response->monthsAnalyses[0];
        parent::assertTrue($september2013 instanceof Month\MonthAnalysis);
        parent::assertEquals(30, $september2013->daysCount);
        parent::assertEquals(6, $september2013->weeksCount);
        parent::assertEquals(7, $september2013->firstDayOfWeek);
        parent::assertEquals(35, $september2013->firstWeekNumber);
    }

    public function testAnalyzeAlMonthsIn2013()
    {
        $this->loadAnalyzerResponse('2013-01-10', '2013-12-30');
        $this->assertNumberOfAnalyzedMonths(12);
    }

    private function assertNumberOfAnalyzedMonths($monthsCount)
    {
        parent::assertEquals($monthsCount, count($this->response->monthsAnalyses));
    }

    private function loadAnalyzerResponse($dateStart, $dateEnd)
    {
        $request = $this->getAnalyzerRequest($dateStart, $dateEnd);
        $this->response = $this->interactor->__invoke($request);
    }

    private function getAnalyzerRequest($dateStart, $dateEnd)
    {
        $request = new CalendarRequest();
        $request->dateStart = new DateTime($dateStart);
        $request->dateEnd = new DateTime($dateEnd);
        $request->events = array();
        $request->eventsDelimiter = '-';
        return $request;
    }
}
