<?php

namespace Scortes\Calendar\Events;

class FindResult
{
    /** @var boolean */
    public $exist;
    /** @var EventNode|null */
    public $event;

    public static function success(EventNode $event)
    {
        return new self($event);
    }

    public static function fail()
    {
        return new self();
    }

    private function __construct(EventNode $event = null)
    {
        $this->exist = $event != null;
        $this->event = $event;
    }
}
