<?php

namespace Scortes\Calendar;

class CalendarRequest
{
    /** @var \DateTime|null */
    public $dateStart;
    /** @var \DateTime|null */
    public $dateEnd;
    /** @var array[date => event] */
    public $events = array();
}
