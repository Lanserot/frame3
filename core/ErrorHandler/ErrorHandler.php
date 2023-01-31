<?php

namespace Core\ErrorHandler;

use Exception;

class ErrorHandler extends Exception
{

    static public function myHandler(int $level, string $message, string $file, int $line): void
    {
        $back = debug_backtrace();
        ob_start();
        debug_print_backtrace();
        $trace = ob_get_contents();
        ob_end_clean();
        $trace = preg_replace('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1);
        $trace = str_replace('#', '<br>#', $trace);
        $lines = file($back[0]['args'][2]);
        $lineNum = $back[0]['args'][3];
        self::printErrorPage($message, $trace, $lines, $lineNum);
        exit();
    }

    static public function shutdown()
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
            $lines = file($error['file']);
            $lineNum = $error['line'];
            self::printErrorPage($errorText, $errorStack, $lines, $lineNum);
            exit();
        }
    }
    static private function printErrorPage(string $errorText, string $errorStack, $lines, int $lineNum): void
    {
        echo '<!DOCTYPE html>
            <html lang="en">
            
            <head>
              <meta charset="UTF-8">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
              <link rel="stylesheet" href="/public/templates/css/style.css">
            
              <title>Error</title>
            </head>
            
            <body style="background:#dad9d9">
            <div class="container"> 
            <div class="row" > 
            <div class="col-lg-12 mt-5" style="background:white "> 
                <p style="display: table-cell;
                vertical-align: middle;
                padding: 10px 20px;">' . $errorText . '</p>
            </div>
            </div>
            <div class="row mt-5" style="background:white "> 
            <div class="col-lg-6"> 
            ' . $errorStack . '
            </div>
            <div class="col-lg-6"> 
                <p>';
        echo '<pre>';
        self::printFileLines($lines, $lineNum);
        echo '</pre>
            </p>
            </div>
            </div>
            </div>
            </body>';
    }

    static private function printFileLines($lines, int $lineNum): void
    {
        foreach ($lines as $line_num => $line) {
            if ($line_num + 10 >= $lineNum - 1 && $lineNum - 1 >= $line_num - 10) {
                if ($line_num == $lineNum - 1) {
                    echo $line_num . '   <span style="color:#f18a8a">' . htmlspecialchars($line) . '</span>';;
                } else {
                    echo $line_num . '   ' . htmlspecialchars($line) . '';
                }
            }
        }
    }
}
