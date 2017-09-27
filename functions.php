<?php
require_once 'mysql_helper.php';
require_once 'vendor/autoload.php';

function renderTemplate($path, $arr) {
    if (!file_exists($path)) {
        return '';
    }

    extract($arr, EXTR_SKIP);

    ob_start();
    require_once($path);
    $content = ob_get_clean();

    return $content;
}

function getRelativeDate($ts) {
    $current_time = strtotime('now');
    $time_left = $current_time - $ts;
    $hour = 3600;
    $day = 86400;

    if ($time_left >= $day) {
        return date("d.m.Y H:i", $ts);
    } elseif ($time_left >= $hour) {
        return floor($time_left / 3600) . ' часов назад';
    } else {
        return floor($time_left / 60) . ' минут назад';
    }
}

function lotTimeRemaining($date) {
    date_default_timezone_set('Europe/Moscow');
    $tomorrow = strtotime($date);
    $now = strtotime('now');

    $lot_time_remaining = date("H:i", $tomorrow - $now);

    return $lot_time_remaining;
}

function selectFromDatabase($connect, $query, $values = []) {
    $stmt = db_get_prepare_stmt($connect, $query, $values);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $query_res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($query_res, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function insertIntoDatabase($connect, $table, $values) {
    $keys = array_keys($values);
    $vals = array_values($values);
    $placeholders = array_fill(0, count($keys), '?');

    $keys_str = implode(', ', $keys);
    $values_str = implode(', ', $placeholders);

    $query = 'INSERT INTO ' . $table . '(' . $keys_str . ') VALUES (' . $values_str .  ')';

    $stmt = db_get_prepare_stmt($connect, $query, $vals);

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        return false;
    }

    return mysqli_insert_id($connect);
}

function randomQuery($connect, $query, $values = []) {
    $stmt = db_get_prepare_stmt($connect, $query, $values);

    return mysqli_stmt_execute($stmt);
}

function sendEmail($email, $name, $lot_id, $lot_name) {
    $body = renderTemplate('templates/email.php', [
        'username' => $name,
        'email' => $email,
        'id' => $lot_id,
        'lot_name' => $lot_name
    ]);

    $transport = (new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
        -> setUsername('doingsdone@mail.ru')
        -> setPassword('rds7BgcL');

    $message = (new Swift_Message('Ваша ставка победила'))
        -> setTo([$email => $name])
        -> setContentType('text/html')
        -> setBody($body)
        -> setFrom(['doingsdone@mail.ru' => 'YetiCave']);

    $mailer = (new Swift_Mailer($transport));
    $mailer -> send($message);
}