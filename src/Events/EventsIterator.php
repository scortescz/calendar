<?php

namespace Scortes\Calendar\Events;

interface EventsIterator extends \IteratorAggregate
{
    public function iterate($date);
}
