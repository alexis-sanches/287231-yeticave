<?php
require_once 'functions.php';

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'yeticave';

$con = mysqli_connect($host, $username, $password, $database);

if ($con == false) {
    $error = mysqli_connect_error();

    $main_content = renderTemplate('templates/error.php', [
        'error' => $error
    ]);

    $layout_content = renderTemplate('templates/layout.php', [
        'main_content' => $main_content,
        'user_avatar' => $user_avatar,
        'title' => 'Ошибка подключения к БД'
    ]);

    print($layout_content);
    exit();
}
