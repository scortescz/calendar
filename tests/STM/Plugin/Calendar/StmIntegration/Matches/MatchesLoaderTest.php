<?php

namespace STM\Plugin\Calendar\StmIntegration\Matches;

use STM\Match\MatchSelection;

require_once(STM_BOOTSTRAP);

/**
 * @group stm_calendar
 */
class MatchesLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var MatchesLoader */
    private $loader;

    protected function setUp()
    {
        $this->loader = new MatchesLoader();
    }

    public function testStmMatchesAreLoaded()
    {
        $matches = $this->loadMatches($this->getMatchSelection());
        $this->assertAtLeastOneMatchWasLoaded($matches);
        foreach ($matches as $match) {
            $this->assertMatch($match);
            $this->assertDate($match);
        }
    }

    private function loadMatches($matchSelection)
    {
        $this->loader->setMatchSelection($matchSelection);
        return $this->loader->getMatches();
    }

    private function getMatchSelection()
    {
        return array(
            'matchType' => MatchSelection::PLAYED_MATCHES,
            'loadScores' => false,
            'loadPeriods' => false
        );
    }

    private function assertAtLeastOneMatchWasLoaded($matches)
    {
        parent::assertTrue(count($matches) > 0);
    }

    private function assertMatch($match)
    {
        parent::assertTrue($match instanceof \STM\Match\Match);
    }

    private function assertDate($match)
    {
        $date = $this->loader->matchDateToString($match);
        parent::assertTrue(is_string($date));
    }

    public function testLastModIsIntegerTimestamp()
    {
        $this->loader->setMatchSelection($this->getMatchSelection());
        parent::assertTrue(is_int($this->loader->getLastmodDateForMatchSelection()));
    }
}
