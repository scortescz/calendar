<?php

namespace Scortes\Calendar;

/** @return \Scortes\Calendar\Calendar */
function createCalendar(CalendarRequest $request)
{
    $uc = new CreateCalendar(new Month\CreateMonthsInterval(new Month\AnalyzeMonth()));
    return $uc($request);
}
