<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\StmIntegration;

class StmCalendarRequest
{
    /** @var string */
    public $dateFormat;
    /** @var string */
    public $dateDelimiter;
    /** @var string */
    public $dateMin;
    /** @var string */
    public $dateMax;
    /** @var array */
    public $matchSelection;
    /** @var boolean */
    public $deleteBoundaryMonthsWithoutMatches;
}
