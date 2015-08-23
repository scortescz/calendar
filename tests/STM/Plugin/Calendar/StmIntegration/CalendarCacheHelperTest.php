<?php

namespace STM\Plugin\Calendar\StmIntegration;

require_once(STM_BOOTSTRAP);

/**
 * @group stm_calendar
 */
class CalendarCacheHelperTest extends \PHPUnit_Framework_TestCase
{
    /** @var CalendarCacheHelper */
    private $object;
    /** @var \STM\Plugin\Calendar\StmIntegration\StmCalendarRequest */
    private $requestTeamOne;
    /** @var \STM\Plugin\Calendar\StmIntegration\StmCalendarRequest */
    private $requestTeamOneAndTwo;

    protected function setUp()
    {
        $this->object = new CalendarCacheHelper(__DIR__);
        $this->requestTeamOne = $this->createRequest(1);
        $this->requestTeamOneAndTwo = $this->createRequest(1, 2);
    }

    private function createRequest()
    {
        $request = new StmCalendarRequest();
        $request->dateFormat = 'Y-n-j';
        $request->dateMin = '2013-7-1';
        $request->dateMax = '2013-11-31';
        $request->matchSelection = array(
            'matchType' => \STM\Match\MatchSelection::ALL_MATCHES,
            'loadScores' => true,
            'loadPeriods' => false,
            'teams' => func_get_args(),
        );
        return $request;
    }

    public function testPathToFileContainsDirectory()
    {
        $cache = new CalendarCacheHelper('directory');
        $cache->setRequest($this->requestTeamOne);
        parent::assertTrue(is_int(strpos($cache->getCacheFilePath(), 'directory')));
    }

    public function testUniquePathForDifferentRequests()
    {
        $pathOne = $this->getCachePath($this->requestTeamOne);
        $pathTwo = $this->getCachePath($this->requestTeamOneAndTwo);
        parent::assertFalse($pathOne === $pathTwo);

        $this->requestTeamOne->matchSelection['competition'] = 9;
        $pathThree = $this->getCachePath($this->requestTeamOne);
        parent::assertFalse($pathOne === $pathThree);
    }

    private function getCachePath($request)
    {
        $this->object->setRequest($request);
        return $this->object->getCacheFilePath();
    }

    public function testLoaderCanBeUsedInFileCacheLibrary()
    {
        parent::assertTrue($this->object->getCalendarSource() instanceof \STM\Libs\FileCache\ISource);
    }
}
