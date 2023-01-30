<?php

// включаем отображение всех ошибок, кроме E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

class BaseException extends Exception
{
}

// наш обработчик ошибок
function myHandler($level, $message, $file, $line)
{
    // в зависимости от типа ошибки формируем заголовок сообщения
    switch ($level) {
        case E_WARNING:
            $type = 'Warning';
            break;
        case E_NOTICE:
            $type = 'Notice';
            break;
        default;
            return false;
    }
    echo "<p>$type: $message</p>";
    echo "<p><strong>File</strong>: $file:$line</p>";
    exit;
}

set_error_handler('myHandler', E_ALL);
function shutdown()
{
    $error = error_get_last();
    if (
        is_array($error) &&
        in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])
    ) {
        while (ob_get_level()) {
            ob_end_clean();
        }
        $errorStack = explode('Stack trace:', $error['message']);
        $errorText = array_shift($errorStack);
        $errorStack = explode('#', current($errorStack));
        array_shift($errorStack);
        $errorStack = implode('<br><br>', $errorStack);
        echo "<div style=\"background-color:black; padding: 10px; \"> 
        <p style=\"color:white;     font-family: sans-serif;\">$errorText<p>
        </div>";
        echo "<div style=\"display:flex\">
        <div style=\"background-color:black; padding: 10px; width: 30%\"> 
        <p style=\"color:#5eb35e;     font-family: sans-serif;\">$errorStack<p>
        </div>";
        $lines = file($error['file']);
        echo "<div style=\"background-color:black; padding: 10px; width: 70%\">";
        echo "<pre style=\"margin:0\">";
        echo "<p style=\"color:#5eb35e;     font-family: sans-serif; margin:0\">";
        foreach ($lines as $line_num => $line) {
            if ($line_num + 10 >= $error['line'] - 1 && $error['line'] - 1 >= $line_num - 10) {
                if ($line_num == $error['line'] - 1) {
                    echo '<span style="color:#f18a8a">' . htmlspecialchars($line) . '</span>';;
                } else {
                    echo htmlspecialchars($line) . '';
                }
            }
        }
        echo "";
        echo "<p></pre></div></div>";
        exit();
    }
}
register_shutdown_function('shutdown');

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    exit('Необходимо выполнить "composer install"');
}

require_once __DIR__ . '/vendor/autoload.php';

use Core\Route\Route;

require __DIR__ . '/core/Route/web.php';

Route::run();
