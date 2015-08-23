<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dateStart = new DateTime('now - 1 year');
$dateEnd = new DateTime('now + 2 months');
$months = \Scortes\Calendar\createMonthsInterval($dateStart, $dateEnd);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Months</title>
        <style>
            td, th {
                border-bottom: 1px solid #ccc;
                padding: 5px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        
        <h1>Months <?php echo "from {$dateStart->format('Y-m-d')} to {$dateEnd->format('Y-m-d')}"; ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Month</th>
                    <th>Days Count</th>
                    <th>Weeks Count</th>
                    <th>First Day of Week</th>
                    <th>First Week Number</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($months as $month): ?>
                <tr>
                    <td><?php echo $month->year; ?></td>
                    <td><?php echo $month->monthNumber; ?></td>
                    <td><?php echo $month->daysCount; ?></td>
                    <td><?php echo $month->weeksCount; ?></td>
                    <td><?php echo $month->firstDayOfWeek; ?></td>
                    <td><?php echo $month->firstWeekNumber; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
