<?php

/**
 * convert array object to string
 *
 * @param array $array
 * @param string $field
 * @param string $implode
 * @return string
 */
function convertArrayObjectToString($array = [], $field = 'name', $implode = ',') {
    $convert = [];
    foreach ($array as $item) {
        array_push($convert, $item->{$field});
    }
    return implode($implode, $convert);
}

/**
 * trim element in array
 *
 * @param array $array
 * @return array
 */
function trimElementInArray($array = []) {
    $result = [];
    foreach ($array as $item) {
        array_push($result, trim($item));
    }
    return $result;
}
