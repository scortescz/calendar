<?php

namespace STM\Plugin\Calendar\StmIntegration\Matches;

/**
 * @group stm_calendar
 */
class MatchesToEventsTest extends \PHPUnit_Framework_TestCase
{
    /** @var MatchesToEvents */
    private $object;
    /** @var MatchesMock */
    private $matchesMock;

    protected function setUp()
    {
        $this->object = new MatchesToEvents();
        $this->matchesMock = new MatchesMock();
    }

    public function testNoInputMatches()
    {
        $this->matchesMock->matches = array();
        $this->assertExpectedMatches(array());
    }

    private function assertExpectedMatches($expectedMatches)
    {
        parent::assertEquals($expectedMatches, $this->object->transform($this->matchesMock));
    }

    public function testMatchesFromJuneAndAugust()
    {
        $expectedMatches = array(
            '2013-06-01' => '2013-06-01',
            '2013-08-01' => '2013-08-01',
        );
        $this->matchesMock->matches = array_values($expectedMatches);
        $this->assertExpectedMatches($expectedMatches);
    }
}
