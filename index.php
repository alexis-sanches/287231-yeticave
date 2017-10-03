<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'vendor/autoload.php';
require_once 'getwinner.php';

ini_set('display_errors', 'On');

$limit = 3;
$curr_page = $_GET['page'] ?? 1;
$total_items = selectFromDatabase($con, 'SELECT COUNT(*) AS cnt FROM lots WHERE winner_id IS NULL')[0]['cnt'];

$offset = ($curr_page - 1) * $limit;
$range = range(1, ceil($total_items / $limit));

$lots_query = 'SELECT l.id, l.title, price, image_url, c.title AS cat_title, finished_at FROM lots l 
JOIN categories c ON l.category_id = c.id 
WHERE winner_id IS NULL 
GROUP BY l.id 
ORDER BY l.created_at DESC
LIMIT ? OFFSET ?';

$goods = selectFromDatabase($con, $lots_query, [$limit, $offset]);

$main_content = renderTemplate('templates/index.php', [
    'range' => $range,
    'limit' => $limit,
    'total_items' => $total_items,
    'page' => $curr_page,
    'goods' => $goods,
    'categories' => $categories,
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'categories_layout' => $categories_layout,
    'title' => 'Главная'
]);

print($layout_content);


