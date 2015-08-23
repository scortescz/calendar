<?php

namespace Scortes\Calendar;

interface Calendar
{
    /**
     * @param \Scortes\Calendar\CalendarRequest $request
     * @return \Scortes\Calendar\CalendarResponse
     */
    public function execute(CalendarRequest $request);
}
