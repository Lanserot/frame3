<?php

namespace Core\Tools;

class DebugTool
{
    static public function preData($data): void
    {
        if (is_array($data)) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }

        if(is_string($data)){
            echo '<pre>';
            echo($data);
            echo '</pre>';
        }
    }
}
