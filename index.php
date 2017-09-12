<?php
require_once 'functions.php';
require_once 'lot_list.php';

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = strtotime('now');

$lot_time_remaining = date("H:i", $tomorrow - $now);

$categories = [
    'Доски и лыжи',
    'Крепления',
    'Ботинки',
    'Одежда',
    'Инструменты',
    'Разное'
];

$main_content = renderTemplate('templates/index.php', [
    'goods' => $goods,
    'categories' => $categories
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'title' => 'Главная'
]);

print($layout_content);


