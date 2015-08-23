<?php

namespace Scortes\Calendar;

class CalendarResponse
{
    /** @var \Scortes\Calendar\Today */
    public $today;
    /** @var \Scortes\Calendar\Month\Month[] */
    public $months;
    /** @var \Scortes\Calendar\Events\Events */
    public $events;
}
