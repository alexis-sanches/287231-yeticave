<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

$categories = selectFromDatabase($con, 'SELECT * FROM categories');

$bets = [];

if (isset($_SESSION['user'])) {
    $query = 'SELECT l.id AS id, l.image_url AS image_url, l.title AS lot, b.created_at AS bet_date, cost, l.finished_at AS lot_date, c.title AS category  FROM bets b 
        JOIN users u ON b.user_id = u.id JOIN lots l ON b.lot_id = l.id JOIN categories c ON l.category_id = c.id WHERE b.user_id = ?';
    $bets = selectFromDatabase($con, $query, [$_SESSION['user']['id']]);
}

$main_content = renderTemplate('templates/mylots.php', [
    'bets' => $bets,
    'categories' => $categories
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'title' => 'Мои ставки',
    'categories' => $categories
]);

print($layout_content);
