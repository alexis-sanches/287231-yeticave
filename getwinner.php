<?php
require_once 'functions.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

$lots_query = 'SELECT id, title FROM lots WHERE winner_id IS NULL AND DATE(finished_at) <= NOW()';

$lots_to_close = selectFromDatabase($con, $lots_query);

if (count($lots_to_close) > 0) {
    $bets_query = 'SELECT b.user_id AS user_id, name, email, l.title AS lot_title, cost 
    FROM bets b
    JOIN users u ON u.id = b.user_id
    JOIN lots l ON l.id = b.lot_id
    WHERE lot_id = ?
    ORDER BY cost DESC LIMIT 1';

    $update_query = 'UPDATE lots SET winner_id = ? WHERE id = ?';

    foreach ($lots_to_close as $key => $value) {
        $bets = selectFromDatabase($con, $bets_query, [$value['id']]);

        if (count($bets) > 0) {
            $max_bet = $bets[0];

            $result = randomQuery($con, $update_query, [$max_bet['user_id'], $value['id']]);

            if ($result) {
                sendEmail($max_bet['email'], $max_bet['name'], $value['id'], $max_bet['lot_title']);
            }
        }
    }
}








