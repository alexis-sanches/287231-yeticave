<?php
require_once 'functions.php';
require_once 'lot_list.php';

session_start();

$user_avatar = 'img/user.jpg';

$bets = [];

foreach ($_COOKIE as $name => $value) {
    if (substr($name, 0, 3) == 'bet') {
        $lot_id = substr($name, 3);

        if (!isset($goods[$lot_id])) {
            continue;
        }

        $lot = $goods[$lot_id];
        
        $bet = json_decode($value, true);

        $bets[] = [
            'id' => $lot_id,
            'title' => $lot['title'],
            'image_url' => $lot['image_url'],
            'category' => $lot['category'],
            'cost' => $bet['cost'],
            'time' => $bet['time'],
            'remaining' => lotTimeRemaining()
        ];
    }
}

$main_content = renderTemplate('templates/mylots.php', [
    'bets' => $bets
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'user_avatar' => $user_avatar,
    'title' => 'Главная'
]);

print($layout_content);
