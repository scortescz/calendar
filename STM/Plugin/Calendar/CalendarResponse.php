<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar;

class CalendarResponse
{
    /** @var \STM\Plugin\Calendar\Helpers\Today */
    public $today;
    /** @var \STM\Plugin\Calendar\CalendarMonths */
    public $months;
    /** @var \STM\Plugin\Calendar\CalendarEvents */
    public $events;
    /** @var array */
    public $monthsAnalyses = array();
}
