<?php
use Core\ErrorHandler\ErrorHandler;

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

function myHandler($level, $message, $file, $line)
{
    ErrorHandler::myHandler($level, $message, $file, $line);
}

set_error_handler('myHandler', E_ALL);
function shutdown()
{
    ErrorHandler::shutdown();
}
register_shutdown_function('shutdown');