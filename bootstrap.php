<?php

namespace Scortes\Calendar;

/** @return \Scortes\Calendar\CalendarResponse */
function createCalendar(CalendarRequest $request)
{
    $uc = new CalendarInteractor(new Month\CreateMonthsInterval(new Month\AnalyzeMonth()));
    return $uc($request);
}
