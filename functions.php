<?php
require_once 'mysql_helper.php';

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

function lotTimeRemaining() {
    date_default_timezone_set('Europe/Moscow');
    $tomorrow = strtotime('tomorrow midnight');
    $now = strtotime('now');

    $lot_time_remaining = date("H:i", $tomorrow - $now);

    return $lot_time_remaining;
}

function selectFromDatabase($connect, $query, $values = []) {
    $stmt = db_get_prepare_stmt($connect, $query, $values);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        return mysqli_stmt_fetch($stmt);
    } else {
        return [];
    }
}

function insertIntoDatabase($connect, $table, $values) {
    $keys = [];
    $vals = [];

    foreach ($values as $key => $value) {
        array_push($keys, $key);
        array_push($vals, $value);
    }

    $placeholders = array_fill(0, count($keys), '?');

    $keys_str = implode(', ', $keys);
    $values_str = implode(', ', $placeholders);

    $query = 'INSERT INTO ' . $table . '(' . $keys_str . ') VALUES (' . $values_str .  ')';

    $stmt = db_get_prepare_stmt($connect, $query, $vals);

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        return false;
    }

    return mysqli_insert_id($connect);
}

function randomQuery($connect, $query, $values = []) {
    $stmt = db_get_prepare_stmt($connect, $query, $values);

    return mysqli_stmt_execute($stmt);
}