<?php

function renderTemplate($path, $arr) {
    if (!file_exists($path)) {
        return '';
    }

    extract($arr, EXTR_SKIP);

    ob_start();
    require_once($path);
    $content = ob_get_clean();

    return $content;
}

function getRelativeDate($ts) {
    $current_time = strtotime('now');
    $time_left = $current_time - $ts;
    $hour = 3600;
    $day = 86400;

    if ($time_left >= $day) {
        return date("d.m.Y H:i", $ts);
    } elseif ($time_left >= $hour) {
        return floor($time_left / 3600) . ' часов назад';
    } else {
        return floor($time_left / 60) . ' минут назад';
    }
}
