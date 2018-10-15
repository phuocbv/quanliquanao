<?php

function convertArrayObjectToString($array = [], $field = 'name', $implode = ',') {
    $convert = [];
    foreach ($array as $item) {
        array_push($convert, $item->{$field});
    }
    return implode($implode, $convert);
}