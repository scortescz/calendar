<?php
require_once __DIR__ . '/../vendor/autoload.php';

$request = new \Scortes\Calendar\CalendarRequest();
$request->dateStart = new DateTime('now - 2 month');
$request->dateEnd = null; // use max date from events
$request->events = [
    "now - 1 month" => 'Day in previous month',
    date('Y-n-') . 1 => 'First day in month',
    date('Y-n-') . 16 => '16th day in month',
    "now + 1 month" => 'Day in next month',
];
$request->addEvent(new DateTime('now + 2 months'), 'now + 2 months');

$calendar = Scortes\Calendar\createCalendar($request);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Basic calendar</title>
        <link rel="stylesheet" href="css/calendar.css" />        
    </head>
    <body>
        
        <h1>Calendar</h1>
        
        <h2>Today</h2>
        <ul>
            <li>Current date: 
                <a href="#today"><strong>
                    <?php echo $calendar->today->date->format('j.n.Y'); ?>
                </strong></a>
            </li>
            <li>Current month: <a href="#currentMonth"><strong><?php echo $calendar->today->monthNumber; ?></strong></a></li>
            <li>Current week: <a href="#currentWeek"><strong><?php echo $calendar->today->weekNumber; ?></strong></a></li>
        </ul>
        
        <h2>Basic calendar</h2>
        <?php
        foreach ($calendar->months as $month) {
            $isCurrentMonth = $calendar->today->isCurrentMonth($month);
            $monthId = $isCurrentMonth ? ' id="currentMonth"' : '';
            echo "<h3{$monthId}>Month {$month->monthNumber}/{$month->year}</h3>";

            $currentDay = 1;
            $weekDay = 1;
            echo '<table>';
            for ($week = 0; $week < $month->weeksCount; $week++) {
                $isCurrentWeek = $isCurrentMonth && $calendar->today->isCurrentWeek($month, $week);
                $weekId = $isCurrentWeek ? ' id="currentWeek"' : '';
                echo "<tr{$weekId}>";
                for ($day = 0; $day < 7; $day++) {
                    list($isDayInMonth, $isCurrentDay) = $calendar->today->isCurrentDay($month, $weekDay++, $currentDay);
                    if ($isDayInMonth) {
                        $weekId = $isCurrentWeek && $isCurrentDay ? ' id="today"' : '';
                        echo "<td{$weekId}>";
                        $eventKey = "{$month->year}-{$month->monthNumber}-{$currentDay}";
                        $event = $calendar->events->find($eventKey);
                        if ($event) {
                            echo "<strong title='{$event}'>" . $currentDay . '</strong>';
                        } else {
                            echo "<strong>" . $currentDay . '</strong>';
                        }
                        $currentDay++;
                    } else {
                        echo '<td class="noDay">&nbsp;';
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        ?>


        <h2>Timeline of events</h2>
        <h3>Input event dates</h3>
        <pre><?php echo implode(', ', array_keys($request->events)); ?></pre>

        <h3>All events</h3>
        <?php printEventsList(''); ?>
        
        <h3>Events in current month</h3>
        <?php printEventsList("{$calendar->today->year}-{$calendar->today->monthNumber}"); ?>

        <?php
        function printEventsList($key) {
            global $calendar;
            echo '<ul>';
            foreach ($calendar->events->iterate($key) as $event) {
                echo "<li>{$key} - <strong>{$event}</strong></li>";
            }
            echo '</ul>';
        }
        ?>
        
    </body>
</html>
