<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['cat'])) {
        if (in_array($_GET['cat'], array_column($categories, 'id'))) {
            $lots_query = 'SELECT l.id, l.title, price, image_url, c.title AS cat_title, finished_at FROM lots l 
            JOIN categories c ON l.category_id = c.id 
            WHERE winner_id IS NULL AND c.id = ?
            GROUP BY l.id 
            ORDER BY l.created_at DESC';

            $goods = selectFromDatabase($con, $lots_query, [$_GET['cat'] ?? '']);

            $cat = selectFromDatabase($con, 'SELECT * FROM categories WHERE id = ?', [$_GET['cat']]);

            $main_content = renderTemplate('templates/all-lots.php', [
                'goods' => $goods,
                'categories' => $categories,
                'categories_layout' => $categories_layout,
                'cat' => $cat[0]
            ]);

            $layout_content = renderTemplate('templates/layout.php', [
                'main_content' => $main_content,
                'categories_layout' => $categories_layout,
                'title' => 'Поиск'
            ]);

            print($layout_content);
        }
    }
}
