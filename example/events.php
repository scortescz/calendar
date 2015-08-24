<?php
require_once __DIR__ . '/../vendor/autoload.php';

$events = new \Scortes\Calendar\Events\Events(' ');
$events->set('John', 'John');
$events->set('John Doe', 'John Doe');
$events->set('John Black', 'John Black');
$events->set('John Black', 'Another John Black');
$events->set('Paul Carter', 'Paul Carter');

function show($event)
{
    return is_array($event) ? implode(' | ', $event) : $event;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Events</title>
    </head>
    <body>
        <pre>&lt;?php
$events = new \Scortes\Calendar\Events\Events(' ');
$events->set('John', 'John');
$events->set('John Doe', 'John Doe');
$events->set('John Black', 'John Black');
$events->set('John Black', 'Another John Black');
$events->set('Paul Carter', 'Paul Carter');
</pre>
        
        <h1>Events</h1>
        
        <h2>Find by key</h2>
        <?php
        echo '<ul>';
        foreach (['Paul', 'John', 'John Doe', 'John Black'] as $key) {
            echo "<li>\$events->get('{$key}'): ";
            echo var_dump($events->get($key));
            echo "</li>";
        }
        echo '</ul>';
        ?>
        
        <h2>Iterate all</h2>
        <pre>foreach ($events as $event) {</pre>
        <?php
        echo '<ul>';
        foreach ($events as $event) {
            echo "<li>" . show($event) . "</li>";
        }
        echo '</ul>';
        ?>
        
        <h2>Iterate by key</h2>
        <pre>foreach ($events->iterate('John') as $event) {</pre>
        <?php
        echo '<ul>';
        foreach ($events->iterate('John') as $event) {
            echo "<li>" . show($event) . "</li>";
        }
        echo '</ul>';
        ?>
        
    </body>
</html>
