<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar;

interface Calendar
{
    /**
     * @param \STM\Plugin\Calendar\CalendarRequest $request
     * @return \STM\Plugin\Calendar\CalendarResponse
     */
    public function execute(CalendarRequest $request);
}
