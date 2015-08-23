<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\Events\Helpers;

use STM\Plugin\Calendar\Events\EventNode;
use STM\Plugin\Calendar\Events\FindResult;

class FindResultFactory
{

    public function success(EventNode $event)
    {
        $result = new FindResult();
        $result->exist = true;
        $result->event = $event;
        return $result;
    }

    public function fail()
    {
        $result = new FindResult();
        $result->exist = false;
        $result->event = null;
        return $result;
    }
}
