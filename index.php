<?php
require_once 'functions.php';
require_once 'lot_list.php';

session_start();

$user_avatar = 'img/user.jpg';

$lot_time_remaining = lotTimeRemaining();

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
    'user_avatar' => $user_avatar,
    'title' => 'Главная'
]);

print($layout_content);


