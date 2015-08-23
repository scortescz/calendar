<?php

namespace Scortes\Calendar\Events\Helpers;

use Scortes\Calendar\Events\EventNode;
use Scortes\Calendar\Events\FindResult;

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
