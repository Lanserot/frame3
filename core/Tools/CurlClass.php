<?php

namespace Core\Tools;

use VVF\ErrorHandler\ErrorHandler;

class CurlClass
{
    static public function getSiteContent(string $url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        if(!$output){
            throw new ErrorHandler('Не удалось получить данные с сайта ' . $url);
        }
        return $output;
    }
}
