<?php

namespace STM\Plugin\Calendar\Events;

class EventsIteratorUtil extends \PHPUnit_Framework_TestCase
{

    public static function assertIterator(\IteratorAggregate $iterator, array $expected)
    {
        $iterated = iterator_to_array($iterator);
        parent::assertEquals(count($expected), count($iterated));
        for ($i = 0; $i < count($expected); $i++) {
            parent::assertEquals($expected[$i], $iterated[$i]->unwrap());
        }
    }
}
