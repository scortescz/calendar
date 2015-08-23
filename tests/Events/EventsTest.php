<?php

namespace Scortes\Calendar\Events;

/**
 * @group events
 */
class EventsTest extends \PHPUnit_Framework_TestCase
{
    /** @var DevEvents */
    private $events;

    protected function setUp()
    {
        $this->events = new Events(' ');
    }

    public function testDashAsDelimiter()
    {
        $events = new Events('-');
        $events->set('key', 'value');
        $events->set('key-another', 'value');
        parent::assertEquals('value', $events->find('key')->event);
        parent::assertEquals('value', $events->find('key-another')->event);
    }

    public function testLevelZero()
    {
        $this->assertSettingAndRetrievingValue('', 'value');
    }

    public function testFirstLevel()
    {
        $this->assertSettingAndRetrievingValue('key', 'value');
    }

    public function testTenthLevel()
    {
        $this->assertSettingAndRetrievingValue('1 2 3 4 5 6 7 8 9 10', 'value');
    }

    private function assertSettingAndRetrievingValue($key, $value)
    {
        $this->events->set($key, $value);
        parent::assertEquals($value, $this->events->find($key)->event);
    }

    public function testAddSecondLevelThenAddFirstLevel()
    {
        $this->events->set('key another', 'second');
        $this->events->set('key', 'value');
        parent::assertEquals('value', $this->events->find('key')->event);
        parent::assertEquals('second', $this->events->find('key another')->event);
    }

    public function testOverrideExistingKeyInFirstLevelToSecond()
    {
        $this->events->set('key', 'value');
        $this->events->set('key another', 'override');
        parent::assertEquals('value', $this->events->find('key')->event);
        parent::assertEquals('override', $this->events->find('key another')->event);
    }

    public function testOverrideInLevelZero()
    {
        $this->assertOverridingValues('');
    }

    public function testOverrideExistingKeyInFirstLevel()
    {
        $this->assertOverridingValues('key');
    }

    public function testOverrideExistingKeyInTenthLevel()
    {
        $this->assertOverridingValues('1 2 3 4 5 6 7 8 9 10');
    }

    private function assertOverridingValues($key)
    {
        $this->events->set($key, 'value');
        $this->events->set($key, 'override');
        parent::assertEquals(array('value', 'override'), $this->events->find($key)->event);
    }

    public function testIfKeyExistsInFirstLevel()
    {
        $this->assertExistingKey('key');
    }

    public function testIfKeyExistsInTenthLevel()
    {
        $this->assertExistingKey('1 2 3 4 5 6 7 8 9 10');
    }

    private function assertExistingKey($key)
    {
        parent::assertFalse($this->events->find($key)->exist);
        $this->events->set($key, 'value');
        parent::assertTrue($this->events->find($key)->exist);
    }

    public function testIteratorReturnsEventWithDate()
    {
        $this->events->set('2009-12-12', 'value');

        $iterated = iterator_to_array($this->events->iterate(''));
        parent::assertEquals(1, count($iterated));

        $event = $iterated[0];
        parent::assertTrue($event instanceof Event);
        parent::assertEquals('2009-12-12', $event->date);
        parent::assertEquals('value', $event->unwrap());
        parent::assertEquals(array('value'), $event->events);
    }

    public function testIteratingEvents()
    {
        $this->events->set('2009', '1');
        $this->events->set('2009', '2');
        $this->events->set('2009 12', '3');
        $this->events->set('2010', '4');
        $this->events->set('2011 12', '5');
        $this->events->set('2011 12 20', '6');
        $this->events->set('2013 7 7 7 7', '7');

        $this->assertIterator('', array(array('1', '2'), '3', '4', '5', '6', '7'));
        $this->assertIterator('2009', array(array('1', '2'), '3'));
        $this->assertIterator('2009 12', array('3'));
        $this->assertIterator('2010', array('4'));
        $this->assertIterator('2011', array('5', '6'));
        $this->assertIterator('2011 12', array('5', '6'));
        $this->assertIterator('2011 12 20', array('6'));
        $this->assertIterator('2013', array('7'));
    }

    public function testNoResultsIfUserIteratesUnexistingPath()
    {
        $this->assertIterator('unexisting', array());
    }

    private function assertIterator($startKey, array $expected)
    {
        $iterator = $this->events->iterate($startKey);
        EventsIteratorUtil::assertIterator($iterator, $expected);
    }
}
