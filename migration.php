<?php


require_once __DIR__ . '/vendor/autoload.php';

$opt = getopt("r:");


$list = array_values(array_filter(scandir('migrations'), function ($file) {
    return preg_match('/\.(.*)$/U', $file) && $file != '.' && $file != '..';
}));

foreach ($list as $file) {
    $name = str_replace('.php', '', 'Migrations\\' . $file);
    $class = new $name();

    if ($opt['r'] == ':Migrate') {
        $class->up();
    } else {
        $class->down();
    }
}



