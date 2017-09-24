<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

session_start();

$user_avatar = 'img/user.jpg';

$categories = selectFromDatabase($con, 'SELECT * FROM categories');

$lots_query = 'SELECT l.id, l.title, price, image_url, c.title AS cat_title, finished_at FROM lots l JOIN categories c ON l.category_id = c.id WHERE winner_id IS NULL GROUP BY l.id ORDER BY l.created_at DESC';
$goods = selectFromDatabase($con, $lots_query);

$main_content = renderTemplate('templates/index.php', [
    'goods' => $goods,
    'categories' => $categories
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'categories' => $categories,
    'title' => 'Главная'
]);

print($layout_content);


