<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $categories = selectFromDatabase($con, 'SELECT * FROM categories');

    $lots_query = 'SELECT l.id, l.title, price, image_url, c.title AS cat_title, finished_at FROM lots l 
    JOIN categories c ON l.category_id = c.id 
    WHERE winner_id IS NULL AND MATCH(l.title, description) AGAINST(?)
    GROUP BY l.id 
    ORDER BY l.created_at DESC';

    $goods = selectFromDatabase($con, $lots_query, [$_GET['search']]);

    $main_content = renderTemplate('templates/search.php', [
        'goods' => $goods,
        'categories' => $categories,
        'query' => $_GET['search']
    ]);

    $layout_content = renderTemplate('templates/layout.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'title' => 'Поиск'
    ]);

    print($layout_content);
}

