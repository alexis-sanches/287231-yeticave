<?php

require_once 'functions.php';
require_once 'lot_list.php';


function getLot($arr, $i) {
    return $arr[$i];
}

if (isset($_GET['lot']) && isset($goods[$_GET['lot']])) {
    $lot = getLot($goods, $_GET['lot']);
} else {
    http_response_code(404);
    exit();
}

$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

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

$main_content = renderTemplate('templates/lot.php', [
    'goods' => $goods,
    'bets' => $bets,
    'lot' => $lot
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'title' => $lot['title']
]);

print($layout_content);
