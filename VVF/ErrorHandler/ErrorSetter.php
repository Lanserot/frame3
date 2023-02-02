<?php
use VVF\ErrorHandler\ErrorHandler;

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

function myHandler($level, $message, $file, $line)
{
    $handler = new ErrorHandler();
    $handler->myHandler($level, $message, $file, $line);
}

set_error_handler('myHandler', E_ALL);
function shutdown()
{
    $handler = new ErrorHandler();
    $handler->shutdown();
}
register_shutdown_function('shutdown');