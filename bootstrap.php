<?php

namespace Scortes\Calendar;

/** @return \Scortes\Calendar\Calendar */
function createCalendar(CalendarRequest $request)
{
    $uc = new CreateCalendar(usecaseMonths());
    return $uc($request);
}

/** @return \Scortes\Calendar\Month\Month[] */
function createMonthsInterval(\DateTime $dateStart, \DateTime $dateEnd)
{
    $uc = usecaseMonths();
    return $uc($dateStart, $dateEnd);
}

function usecaseMonths()
{
    return new Month\CreateMonthsInterval(new Month\AnalyzeMonth());
}
