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
        
        <pre>&lt;?php
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

\Scortes\Calendar\Html\monthsToTables(
    $calendar,
    array(
        'hideMonthsWithoutEvent' => true,
        'currentId' => array(
            'table' => '',
            'month' => 'currentMonth',
            'week' => 'currentWeek',
            'day' => 'today',
        ),
        'monthName' => function (Scortes\Calendar\Month\Month $month, $monthId) {
            return "&lt;h3{$monthId}>Month {$month->monthNumber}/{$month->year}&lt;/h3>";
        },
        'day' => array(
            'withEvent' => function ($event, $currentDay) {
                return "&lt;strong title='{$event}'>{$currentDay}&lt;/strong>";
            },
            'withoutEvent' => function ($currentDay) {
                return "&lt;strong>{$currentDay}&lt;/strong>";
            },
            'empty' => '&lt;td class="noDay">&nbsp;&lt;/td>'
        )
    )
);

// Events in current month
\Scortes\Calendar\Html\eventsToList(
    $calendar,
    "{$calendar->today->year}-{$calendar->today->monthNumber}",
    function ($event, $key) {
        return "{$key} - &lt;strong>{$event}&lt;/strong>";
    }
);
        </pre>
        
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
        \Scortes\Calendar\Html\monthsToTables(
            $calendar,
            array(
                'hideMonthsWithoutEvent' => true,
                'selectors' => array(
                    'table' => ' class=calendar',
                    'month' => ' id=currentMonth',
                    'week' => ' id=currentWeek',
                    'day' => ' id=today',
                ),
                'monthName' => function (Scortes\Calendar\Month\Month $month, $monthId) {
                    return "<h3{$monthId}>Month {$month->monthNumber}/{$month->year}</h3>";
                },
                'day' => array(
                    'withEvent' => function ($event, $currentDay) {
                        return "<strong title='{$event}'>{$currentDay}</strong>";
                    },
                    'withoutEvent' => function ($currentDay) {
                        return "<strong>{$currentDay}</strong>";
                    },
                    'empty' => '<td class="noDay">&nbsp;</td>'
                )
            )
        );
        ?>


        <h2>Timeline of events</h2>
        <h3>Input event dates</h3>
        <pre><?php echo implode(', ', array_keys($request->events)); ?></pre>

        <h3>All events</h3>
        <?php
        \Scortes\Calendar\Html\eventsToList(
            $calendar,
            '',
            function ($event) {
                return "<strong>{$event}</strong>";
            }
        );
        ?>
        
        <h3>Events in current month</h3>
        <?php
        \Scortes\Calendar\Html\eventsToList(
            $calendar,
            "{$calendar->today->year}-{$calendar->today->monthNumber}",
            function ($event, $key) {
                return "{$key} - <strong>{$event}</strong>";
            }
        );
        ?>
        
    </body>
</html>
