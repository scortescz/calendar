<?php

namespace Scortes\Calendar\Html;

use Scortes\Calendar\Calendar;

function monthsToTables(Calendar $calendar, array $config)
{
    foreach ($calendar->months as $month) {
        ob_start();
        $eventsCount = 0;

        $isCurrentMonth = $calendar->today->isCurrentMonth($month);
        $monthId = $isCurrentMonth ? $config['selectors']['month'] : '';
        echo $config['monthName']($month, $monthId);

        $currentDay = 1;
        $weekDay = 1;
        echo "<table {$config['selectors']['table']}>";
        for ($week = 0; $week < $month->weeksCount; $week++) {
            $isCurrentWeek = $isCurrentMonth && $calendar->today->isCurrentWeek($month, $week);
            $weekId = $isCurrentWeek ? $config['selectors']['week'] : '';
            echo "<tr{$weekId}>";
            for ($day = 0; $day < 7; $day++) {
                list($isDayInMonth, $isCurrentDay) = $calendar->today->isCurrentDay($month, $weekDay++, $currentDay);
                if ($isDayInMonth) {
                    $weekId = $isCurrentWeek && $isCurrentDay ? $config['selectors']['day'] : '';
                    echo "<td{$weekId}>";
                    $eventKey = "{$month->year}-{$month->monthNumber}-{$currentDay}";
                    $event = $calendar->events->find($eventKey);
                    if ($event) {
                        $eventsCount++;
                        echo $config['day']['withEvent']($event, $currentDay);
                    } else {
                        echo $config['day']['withoutEvent']($currentDay);
                    }
                    $currentDay++;
                    echo '</td>';
                } else {
                    echo $config['day']['empty'];
                }
            }
            echo '</tr>';
        }
        echo '</table>';
        
        $monthString = ob_get_clean();
        if (!isset($config['hideMonthsWithoutEvent']) || !$config['hideMonthsWithoutEvent'] || $eventsCount > 0) {
            echo $monthString;
        }
    }
}

function eventsToList(Calendar $calendar, $key, callable $showEvent) {
    echo '<ul>';
    foreach ($calendar->events->iterate($key) as $event) {
        echo "<li>{$showEvent($event, $key)}</strong></li>";
    }
    echo '</ul>';
}
