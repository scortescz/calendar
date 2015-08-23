<?php

namespace Scortes\Calendar;

class CalendarResponse
{
    /** @var \Scortes\Calendar\Today */
    public $today;
    /** @var \Scortes\Calendar\CalendarMonths */
    public $months;
    /** @var \Scortes\Calendar\CalendarEvents */
    public $events;
    /** @var array */
    public $monthsAnalyses = array();
}
