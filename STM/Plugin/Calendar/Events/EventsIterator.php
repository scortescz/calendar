<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\Events;

interface EventsIterator extends \IteratorAggregate
{
    public function iterate($date);
}
