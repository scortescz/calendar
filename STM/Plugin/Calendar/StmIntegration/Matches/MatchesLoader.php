<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\StmIntegration\Matches;

use STM\Cache\CacheHelper;
use STM\StmFactory;

class MatchesLoader implements Matches
{
    /** @var array */
    private $matchSelection;
    /** @var string */
    private $dateFormat;

    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    public function setMatchSelection(array $matchSelection)
    {
        $this->matchSelection = $matchSelection;
    }

    public function getLastmodDateForMatchSelection()
    {
        return CacheHelper::getLastmodDateForMatchSelection($this->matchSelection);
    }

    public function getMatches()
    {
        return StmFactory::find()->Match->find($this->matchSelection);
    }

    public function matchDateToString($match)
    {
        $stmDatetime = $match->getDate();
        if ($stmDatetime->isValid()) {
            $datetime = $stmDatetime->getDatetime();
            return $datetime->format($this->dateFormat);
        }
        return '';
    }
}
