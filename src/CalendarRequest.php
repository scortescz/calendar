<?php

namespace Scortes\Calendar;

class CalendarRequest
{
    /** @var \DateTime */
    public $dateStart;
    /** @var \DateTime */
    public $dateEnd;
    /** @var boolean */
    public $analyzeMonths;
    /** @var array */
    public $events = array();
    /** @var string */
    public $eventsDelimiter;
    /** @var boolean */
    public $deleteBoundaryMonthsWithoutEvents;
}
