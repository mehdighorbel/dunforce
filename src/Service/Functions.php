<?php
namespace App\Service;

class Functions
{
    function multi_array_search($key, $value, array $multiArray) {
        foreach ($multiArray as $index => $array) {
            if ($array[$key] === $value) {
                return $index;
            }
        }
        return null;
    }
}
