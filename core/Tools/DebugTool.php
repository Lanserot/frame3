<?php

namespace Core\Tools;

class DebugTool
{
    static public function preData($data): void
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}
