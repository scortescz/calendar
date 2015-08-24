
# Monthly Event Calendar

license
stable version
versioneye

## Install

```bash
composer require scortes/calendar
```

## [Calendar](/example/index.php)

1. Add events list - every event needs to have date, content of event is up to you (it can be string, object, &hellip;)
2. Optionally you can set min/max dates. If you don't set them then they are automatically calculated
3. Display calendar, you can use helper function `\Scortes\Calendar\HTML\monthsToTables` for classic calendar format

```php
// configure calendar
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

// build calendar
$calendar = Scortes\Calendar\createCalendar($request);

// display calendar
\Scortes\Calendar\HTML\monthsToTables(
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
```

## Components

Calendar consist of two independent components:

* [analyzing months](/example/months.php)
* [data structure for events](/example/events.php)

### Analyze months between two DateTimes

```php
$dateStart = new DateTime('now - 1 month');
$dateEnd = new DateTime('now + 2 months');
$months = \Scortes\Calendar\createMonthsInterval($dateStart, $dateEnd);
```

Year | Month | Days Count | Weeks Count | First Day of Week | First Week Number |
--- | --- | --- | --- | --- | --- |
2015 | 7 | 31 | 5 | 3 | 27 |
2015 | 8 | 31 | 6 | 6 | 31 |
2015 | 9 | 30 | 5 | 2 | 36 |
2015 | 10 | 31 | 5 | 4 | 40 |

### Data structure for events (trie separated by delimiter)

```php
$events = new \Scortes\Calendar\Events\Events(' ');
$events->set('John', 'John');
$events->set('John Doe', 'John Doe');
$events->set('John Black', 'John Black');
$events->set('John Black', 'Another John Black');
$events->set('Paul Carter', 'Paul Carter');

$events->get('John Doe'); // John Doe
$events->get('John Black'); // [John Black, Another John Black]
$events->iterate('John'); // [John, John Doe, [John Black, Another John Black]]
```

## Contributing

Contributions from others would be very much appreciated! Send 
[pull request](https://github.com/scortescz/calendar/pulls)/
[issue](https://github.com/scortescz/calendar/issues). Thanks!

## License

Copyright (c) 2015 Scortes. MIT Licensed,
see [LICENSE](/LICENSE) for details.
