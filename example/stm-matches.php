<?php

require_once(__DIR__ . '/../autoload.php');
require_once(__DIR__ . '/../../_sports_table_manager/stm/bootstrap.php');

$request = new \STM\Plugin\Calendar\StmIntegration\StmCalendarRequest();
$request->dateFormat = 'Y-n-j';
$request->dateDelimiter = '-';
$request->dateMin = '2013-7-1';
$request->dateMax = '2013-11-31';
$request->matchSelection = array(
    'matchType' => \STM\Match\MatchSelection::ALL_MATCHES,
    'loadScores' => true,
    'loadPeriods' => false,
    //'competition' => 8,
    'teams' => array(1),
    'order' => array(
        'datetime' => true,
    )
);
$request->deleteBoundaryMonthsWithoutMatches = true;

$cacheDir = __DIR__ . '/cache/';
$helper = new STM\Plugin\Calendar\StmIntegration\CalendarCacheHelper($cacheDir);
$stm = new \STM\Plugin\Calendar\StmIntegration\StmCalendar($helper);

$response = $stm->execute($request);
echo '<hr />';

echo '<ul>';
foreach ($response->events as $event) {
    echo "<li>{$event->date} - <strong>{$event->unwrap()}</strong></li>";
}
echo '</ul>';
