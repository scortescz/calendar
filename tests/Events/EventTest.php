<?php

namespace Scortes\Calendar\Events;

class EventTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideEvents */
    public function testUnwrappingInstance(array $events, $expectedUnwrappedEvents)
    {
        $event = new Event('irrelevant key');
        $event->events = $events;
        assertThat($event->unwrap(), is($expectedUnwrappedEvents));
    }

    public function provideEvents()
    {
        return [
            'one event -> unshift content' => [['first'], 'first'],
            'no change when events count > 1' => [['first', 'second'], ['first', 'second']],
        ];
    }
}
