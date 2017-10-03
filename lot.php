<?php

require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

ini_set('display_errors', 'On');

$lot = [];

if (isset($_GET['lot'])) {
    $lot_query = '
        SELECT l.id, l.title, description, image_url, author_id, c.title AS category, price, COALESCE(MAX(cost), price) AS curr_price, (COALESCE(MAX(cost), price) + bet_step) AS min_price, bet_step, finished_at   
        FROM lots l 
        JOIN categories c ON c.id = l.category_id 
        LEFT JOIN bets b ON l.id = b.lot_id
        WHERE l.id = ?
        GROUP BY l.id';
    $lots = selectFromDatabase($con, $lot_query, [$_GET['lot']]);

    if (count($lots) == 0) {
        http_response_code(404);
        exit();
    } else {
        $lot = $lots[0];
    }
} else {
    http_response_code(404);
    exit();
}

$bets_query = 'SELECT b.id, b.created_at AS created_at, cost, u.name AS user_name FROM bets b 
    JOIN users u ON u.id = b.user_id
    LEFT JOIN lots l ON l.id = b.lot_id
    WHERE lot_id = ?
    GROUP BY b.id ORDER BY b.created_at DESC';

$bets = selectFromDatabase($con, $bets_query, [$_GET['lot']]);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['cost'])) {
        $errors[] = 'cost';
    } else {
        if (intval($_POST['cost']) < $lot['min_price']) {
            $errors[] = 'cost';
        }
    }

    if (count($errors) == 0) {
        $now = date('Y-m-d H:i:s', strtotime('now'));
        $values = [
            'created_at' => $now,
            'cost' => $_POST['cost'],
            'user_id' => $_SESSION['user']['id'],
            'lot_id' => $_GET['lot'],
        ];

        insertIntoDatabase($con, 'bets', $values);
        header('Location: mylots.php');
    }
}

$main_content = renderTemplate('templates/lot.php', [
    'bets' => $bets,
    'lot' => $lot,
    'errors' => $errors,
    'categories_layout' => $categories_layout,
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'title' => $lot['title'],
    'categories_layout' => $categories_layout,
]);

print($layout_content);
