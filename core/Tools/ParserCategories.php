<?php

namespace Core\Tools;

class ParserCategories
{
    static public function prepareCategories(array $content): array
    {
        $categories = array_keys($content);
        $categoriesPrepare = [];
        foreach ($categories as $category) {
            $max = [];
            foreach ($content[$category] as $preCategory) {
                $max = array_merge($max, array_values($preCategory));
            }
            asort($max);
            $max = array_filter($max, function ($elem) {
                return is_int($elem);
            });
            $categoriesPrepare[$category] = current($max);
        }

        return $categoriesPrepare;
    }

    static function convertDbTopToJson(array $top): array
    {
        $convert = [];
        foreach ($top as $elem) {
            $convert['categories'][$elem['category']] = $elem['position'];
        }

        $convert['status_code'] = 200;
        return $convert;
    }
}
