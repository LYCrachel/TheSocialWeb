<?php namespace socialWeb\core\functions;

use Carbon\Carbon;

/**
 * @param string $field
 * @param \stdClass|array|object $objarray
 *
 * @return null
 */
function val($field, $objarray)
{
    return is_null($field) ? null : @(is_array($objarray) ? $objarray[$field] : $objarray->$field);
}

/**
 * @param $path
 * @param \stdClass|array|object $value
 *
 * @return mixed|null
 */
function nav($path, $value)
{
    if (empty($value)) {
        return $value;
    }

    $segments = array_map(function ($segment) {
        return trim($segment);
    }, explode('->', $path));

    foreach ($segments as $segment) {
        if (is_array($value)) {
            $value = array_key_exists($segment, $value) ? $value[$segment] : null;
        } else if (is_object($value)) {
            $value = isset($value->$segment) ? $value->$segment : null;
        } else {
            return null;
        }
    }
    return $value;
}

/**
 * @return array
 */
function getLanguageCodes()
{
    $languages = [];
    foreach (file(LANGUAGE_MAPPING_CSV, FILE_IGNORE_NEW_LINES) as $key => $value) {
        $languages[$key] = str_getcsv($value);
    }
    $mapped_lang_code = [];
    foreach ($languages as $language) {
        $mapped_lang_code[val(0, $language)] = val(1, $language);
    }
    return $mapped_lang_code;
}

/**
 * @return array
 */
function getTimeQuarters()
{
    return [
        'q1' => [
            'time'  => Q1_TIME,
            'from'  => Carbon::create(null, null, null, 0, 0, 0)->format(TIME_FORMAT),
            'to'    => Carbon::create(null, null, null, 5, 59, 59)->format(TIME_FORMAT)
        ],
        'q2' => [
            'time'  => Q2_TIME,
            'from'  => Carbon::create(null, null, null, 6, 0, 0)->format(TIME_FORMAT),
            'to'    => Carbon::create(null, null, null, 11, 59, 59)->format(TIME_FORMAT)
        ],
        'q3' => [
            'time'  => Q3_TIME,
            'from'  => Carbon::create(null, null, null, 12, 0, 0)->format(TIME_FORMAT),
            'to'    => Carbon::create(null, null, null, 17, 59, 59)->format(TIME_FORMAT)
        ],
        'q4' => [
            'time'  => Q4_TIME,
            'from'  => Carbon::create(null, null, null, 18, 0, 0)->format(TIME_FORMAT),
            'to'    => Carbon::create(null, null, null, 23, 59, 59)->format(TIME_FORMAT)
        ]
    ];
}