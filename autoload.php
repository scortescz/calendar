<?php

function stmPluginAutoload($class)
{
    $isStm = strpos($class, 'STM\Plugin\\') === 0;
    if ($isStm) {
        $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        require_once(__DIR__ . "/{$classPath}.php");
    }
}

spl_autoload_register('stmPluginAutoload');
