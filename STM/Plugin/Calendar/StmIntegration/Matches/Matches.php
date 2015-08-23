<?php
/*
 * Sports Table Manager (https://bitbucket.org/stm-sport)
 * @license New BSD License
 * @author Zdenek Drahos
 */

namespace STM\Plugin\Calendar\StmIntegration\Matches;

interface Matches
{

    /**
     * @return array
     */
    public function getMatches();

    /**
     * @param \STM\Match\Match $match
     * @return string
     */
    public function matchDateToString($match);
}
