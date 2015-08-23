<?php
require_once __DIR__ . '/../vendor/autoload.php';

$interactor = new \Scortes\Calendar\CalendarInteractor();

$currentYear = date('Y');
$currentMonth = date('n');
$previousMonth = $currentMonth - 1;
$nextMonth = $currentMonth + 1;

$request = new \Scortes\Calendar\CalendarRequest();
$request->dateStart = new DateTime('now - 1 month');
$request->dateEnd = new DateTime('now + 1 month');
$request->analyzeMonths = true;
$request->events = array(
    "{$currentYear}-{$previousMonth}-10" => 'Day in previous month',
    "{$currentYear}-{$currentMonth}-1" => 'First day in month',
    "{$currentYear}-{$currentMonth}-16" => '16th day in month',
    "{$currentYear}-{$nextMonth}-17" => 'Day in next month',
);
$request->eventsDelimiter = '-';

$response = $interactor->execute($request);
$events = $response->events;
$today = $response->today;
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
                    <?php echo $today->date->format('j.n.Y'); ?>
                </strong></a>
            </li>
            <li>Current month: <a href="#currentMonth"><strong><?php echo $today->monthNumber; ?></strong></a></li>
            <li>Current week: <a href="#currentWeek"><strong><?php echo $today->weekNumber; ?></strong></a></li>
        </ul>
        
        <h2>Basic calendar</h2>
        <?php
        foreach ($response->months as $id => $month) {
            printMonth($month);
            
            $analysis = $response->monthsAnalyses[$id];
            $currentDay = 1;
            
            echo '<table>';
            
            // 1st week
            $week = 1;
            printRowStartTag($week, $analysis, $month);
            for ($day = 1; $day <= 7; $day++) {
                 $isDayInMonth = $day >= $analysis->firstDayOfWeek;
                 printDayCell($currentDay, $isDayInMonth, $month);
            }
            echo '</tr>';
            
            // middle weeks - 2nd to Xth
            for ($week = 2; $week < $analysis->weeksCount; $week++) {
                printRowStartTag($week, $analysis, $month);
                for ($day = 1; $day <= 7; $day++) {
                    printDayCell($currentDay, true, $month);
                }
                echo '</tr>';
            }
            
            // Last week
            $week = $analysis->weeksCount;
            printRowStartTag($week, $analysis, $month);
            for ($day = 1; $day <= 7; $day++) {
                 $isDayInMonth = $currentDay <= $analysis->daysCount;                 
                 printDayCell($currentDay, $isDayInMonth, $month);
            }
            echo '</tr>';
            
            echo '</table>';
        }
        
        function printMonth($month)
        {
            global $today;
            $isCurrent = 
                $today->monthNumber == $month->monthNumber &&
                $today->year == $month->year;
            $id = $isCurrent ? ' id="currentMonth"' : '';
            echo "<h3{$id}>Month {$month->monthNumber}/{$month->year}</h3>";
        }
        
        function printRowStartTag($week, $analysis, $month)
        {
            global $today;
            $isCurrent = 
                ($analysis->firstWeekNumber + $week - 1) == date('W') &&
                $today->monthNumber == $month->monthNumber &&
                $today->year == $month->year;
            if ($isCurrent) {
                echo '<tr id="currentWeek">';
            } else {
                echo '<tr>';
            }
            echo '<th>' . ($analysis->firstWeekNumber + $week - 1) . '</th>';
        }
        
        function printDayCell(&$currentDay, $isDayInMonth, $month)
        {
            global $today;
            
            $isToday = $currentDay == date('j') &&
                $today->monthNumber == $month->monthNumber &&
                $today->year == $month->year;
            if ($isToday) {
                echo '<td id="today">';
            } else {
                if ($isDayInMonth) {
                    echo '<td>';
                } else {
                    echo '<td class="noDay">';
                }
            }
            if ($isDayInMonth) {
                global $events;
                $eventKey = "{$month->year}-{$month->monthNumber}-{$currentDay}";
                if ($events->existsEvent($eventKey)) {
                    $event = $events->getEvent($eventKey);
                    echo "<strong title='{$event}'>" . $currentDay . '</strong>';
                } else {
                    echo "<strong>" . $currentDay . '</strong>';
                }
                $currentDay++;
            } else {
                echo '&nbsp;';
            }
            echo '</td>';
        }
        ?>

        <h2>Timeline of events</h2>
        <h3>All events</h3>
        <?php printEventsList(''); ?>
        
        <h3>Events in current month</h3>
        <?php printEventsList("{$today->year}-{$today->monthNumber}"); ?>
        
        
        <?php
        function printEventsList($key) {
            global $events;
            echo '<ul>';
            foreach ($events->iterate($key) as $event) {
                echo "<li>{$event->date} - <strong>{$event->unwrap()}</strong></li>";
            }
            echo '</ul>';
        }
        ?>
        
    </body>
</html>
