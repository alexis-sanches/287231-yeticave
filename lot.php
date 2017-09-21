<?php

require_once 'functions.php';
require_once 'lot_list.php';
require_once 'mysql_helper.php';
require_once 'init.php';

session_start();

$user_avatar = 'img/user.jpg';


function getLot($arr, $i) {
    return $arr[$i];
}

if (isset($_GET['lot']) && isset($goods[$_GET['lot']])) {
    $lot = getLot($goods, $_GET['lot']);
} else {
    http_response_code(404);
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cost'])) {
    $value = [
        'cost' => $_POST['cost'],
        'time' => strtotime('now')
    ];

    setcookie('bet' . $_GET['lot'], json_encode($value), strtotime('next month'), '/');

    header('Location: mylots.php');
}

$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

$main_content = renderTemplate('templates/lot.php', [
    'goods' => $goods,
    'bets' => $bets,
    'lot' => $lot,
    'id' => $_GET['lot'],
    'errors' => $errors
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'user_avatar' => $user_avatar,
    'title' => $lot['title']
]);

print($layout_content);
