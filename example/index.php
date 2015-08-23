<?php
require_once __DIR__ . '/../vendor/autoload.php';

$currentYear = date('Y');
$currentMonth = date('n');
$previousMonth = $currentMonth - 1;
$nextMonth = $currentMonth + 1;

$request = new \Scortes\Calendar\CalendarRequest();
$request->dateStart = new DateTime('now - 1 month');
$request->dateEnd = new DateTime('now + 1 month');
$request->events = array(
    "{$currentYear}-{$previousMonth}-10" => 'Day in previous month',
    "{$currentYear}-{$currentMonth}-1" => 'First day in month',
    "{$currentYear}-{$currentMonth}-16" => '16th day in month',
    "{$currentYear}-{$nextMonth}-17" => 'Day in next month',
);
$request->eventsDelimiter = '-';

$interactor = new \Scortes\Calendar\CalendarInteractor(
    new Scortes\Calendar\Month\MonthsBetweenDates(),
    new Scortes\Calendar\Month\MonthAnalyzer()
);
$response = $interactor($request);
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
                    <?php echo $response->today->date->format('j.n.Y'); ?>
                </strong></a>
            </li>
            <li>Current month: <a href="#currentMonth"><strong><?php echo $response->today->monthNumber; ?></strong></a></li>
            <li>Current week: <a href="#currentWeek"><strong><?php echo $response->today->weekNumber; ?></strong></a></li>
        </ul>
        
        <h2>Basic calendar</h2>
        <?php
        foreach ($response->months as $id => $month) {
            $isCurrentMonth = 
                $response->today->monthNumber == $month->monthNumber &&
                $response->today->year == $month->year;
            $monthId = $isCurrentMonth ? ' id="currentMonth"' : '';
            echo "<h3{$monthId}>Month {$month->monthNumber}/{$month->year}</h3>";

            $currentDay = 1;
            $emptyDate = 1;
            echo '<table>';
            for ($week = 0; $week < $month->weeksCount; $week++) {
                $isCurrentWeek = $isCurrentMonth && $response->today->weekNumber == ($month->firstWeekNumber + $week);
                $weekId = $isCurrentWeek ? ' id="currentWeek"' : '';
                echo "<tr{$weekId}>";
                for ($day = 0; $day < 7; $day++) {
                    $isDayInMonth = $emptyDate++ >= $month->firstDayOfWeek && $currentDay <= $month->daysCount;
                    if ($isDayInMonth) {
                        $weekId = $isCurrentWeek && $currentDay == $response->today->day ? ' id="today"' : '';
                        echo "<td{$weekId}>";
                        $eventKey = "{$month->year}-{$month->monthNumber}-{$currentDay}";
                        if ($response->events->existsEvent($eventKey)) {
                            $event = $response->events->getEvent($eventKey);
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
        <h3>All events</h3>
        <?php printEventsList(''); ?>
        
        <h3>Events in current month</h3>
        <?php printEventsList("{$response->today->year}-{$response->today->monthNumber}"); ?>

        <?php
        function printEventsList($key) {
            global $response;
            echo '<ul>';
            foreach ($response->events->iterate($key) as $event) {
                echo "<li>{$event->date} - <strong>{$event->unwrap()}</strong></li>";
            }
            echo '</ul>';
        }
        ?>
        
    </body>
</html>
