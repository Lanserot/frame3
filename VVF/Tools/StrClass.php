<?php

namespace VVF\Tools;

class StrClass
{
    public static function handleRandomStringInArray(array $data): array
    {
        for ($i = 0; $i < count($data); $i++) {
            if (strripos($data[$i], '|randString|') !== false) {
                $length = rand(5, 10);
                $string = '';
                while (($len = strlen($string)) < $length) {
                    $size = $length - $len;
                    $string .= substr(str_replace(['/', '+', '='], '', base64_encode(random_bytes($size))), 0, $size);
                }
                $data[$i] = str_replace('|randString|', $string, $data[$i]);
            }
            if (strripos($data[$i], '|randInt|') !== false) {
                $data[$i] = str_replace('|randInt|', rand(1, 15), $data[$i]);
            }
        }

        return $data;
    }
}