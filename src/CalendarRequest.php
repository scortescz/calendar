<?php

namespace Scortes\Calendar;

class CalendarRequest
{
    /** @var \DateTime */
    public $dateStart;
    /** @var \DateTime */
    public $dateEnd;
    /** @var array */
    public $events = array();
    /** @var string */
    public $eventsDelimiter;
}
