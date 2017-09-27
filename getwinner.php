<?php
require_once 'functions.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

$lots_query = 'SELECT l.id AS lot_id, l.title AS title, name, email
FROM lots l
  LEFT JOIN bets b ON l.id = b.lot_id
  JOIN users u ON u.id = b.user_id
WHERE winner_id IS NULL AND DATE(finished_at) <= NOW()
GROUP BY l.id';

$update_query = 'UPDATE lots SET winner_id = ? WHERE id = ?';

$lots_to_close = selectFromDatabase($con, $lots_query);

foreach ($lots_to_close as $key => $value) {
    $result = randomQuery($con, $update_query, [$value['user_id'], $value['lot_id']]);

    if ($result) {
        sendEmail($value['email'], $value['name'], $value['lot_id'], $value['title']);
    }
}
