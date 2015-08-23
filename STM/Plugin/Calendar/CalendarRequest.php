<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar;

class CalendarRequest
{
    /** @var \DateTime */
    public $dateStart;
    /** @var \DateTime */
    public $dateEnd;
    /** @var boolean */
    public $analyzeMonths;
    /** @var array */
    public $events = array();
    /** @var string */
    public $eventsDelimiter;
    /** @var boolean */
    public $deleteBoundaryMonthsWithoutEvents;
}
