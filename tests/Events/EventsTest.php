<?php

namespace Scortes\Calendar\Events;

class EventsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Events */
    private $events;

    protected function setUp()
    {
        $this->events = new Events(' ');
    }

    /** @dataProvider provideLevels */
    public function testSetAndGetValue($key)
    {
        assertThat($this->events->get($key), is(nullValue()));
        $this->events->set($key, 'value');
        assertThat($this->events->get($key), is('value'));
    }

    /** @dataProvider provideLevels */
    public function testMergeValuesWithSameKey($key)
    {
        $this->events->set($key, 'value');
        $this->events->set($key, 'override');
        assertThat($this->events->get($key), arrayWithSize(2));
    }

    public function provideLevels()
    {
        return [
            'level 0' => [''],
            'level 1' => ['key'],
            'level 10' => ['1 2 3 4 5 6 7 8 9 10'],
        ];
    }

    /** @dataProvider provideKeys */
    public function testBuildLevels(array $events)
    {
        foreach ($events as $key => $event) {
            $this->events->set($key, $event);
        }
        parent::assertEquals('first', $this->events->get('key'));
        parent::assertEquals('second', $this->events->get('key another'));
    }

    public function provideKeys()
    {
        return [
            'add first level, then second level' => [['key' => 'first', 'key another' => 'second']],
            'add second level, then first level' => [['key another' => 'second', 'key' => 'first']],
        ];
    }

    /** @dataProvider provideIterators */
    public function testIteratorReturnsWrappedEvents($startKey, $expected)
    {
        $this->events->set('2009', '1');
        $this->events->set('2009', '2');
        $this->events->set('2009 12', '3');
        $this->events->set('2010', '4');
        $this->events->set('2011 12', '5');
        $this->events->set('2011 12 20', '6');
        $this->events->set('2013 7 7 7 7', '7');
        $iterator = $this->events->iterate($startKey);
        assertThat(iterator_to_array($iterator), identicalTo($expected));
    }

    public function provideIterators()
    {
        return [
            ['unexistingKey', []],
            ['', [['1', '2'], '3', '4', '5', '6', '7']],
            ['2009', [['1', '2'], '3']],
            ['2009 12', ['3']],
            ['2010', ['4']],
            ['2011', ['5', '6']],
            ['2011 12', ['5', '6']],
            ['2011 12 20', ['6']],
            ['2013', ['7']],
        ];
    }
}
