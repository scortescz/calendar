<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\StmIntegration;

use STM\Cache\CacheHelper;
use STM\Plugin\Calendar\Helpers\Today;

class StmCalendar
{
    /** @var CalendarCacheHelper */
    private $cacheHelper;
    /** @var \STM\Plugin\Calendar\CalendarResponse */
    private $response;
    
    public function __construct(CalendarCacheHelper $cacheHelper)
    {
        $this->cacheHelper = $cacheHelper;
    }

    /**
     * @param \STM\Plugin\Calendar\StmIntegration\StmCalendarRequest $request
     * @return \STM\Plugin\Calendar\CalendarResponse
     */
    public function execute(StmCalendarRequest $request)
    {
        $this->setRequest($request);
        $this->loadResponse();
        $this->updateTodayInResponse();
        return $this->response;
    }

    private function setRequest($request)
    {
        $this->cacheHelper->setRequest($request);
    }

    private function loadResponse()
    {
        $source = $this->cacheHelper->getCalendarSource();
        $file = $this->cacheHelper->getCacheFilePath();
        $this->response = CacheHelper::getContentFromCache($source, $file);
    }

    private function updateTodayInResponse()
    {
        $this->response->today = new Today();
    }
}
