<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'userdata.php';

session_start();

$user_avatar = 'img/user.jpg';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $emails = array_column($users, 'email');

    foreach ($_POST as $key => $value) {
        if (!$value) {
            $errors += [$key => $key == 'email' ? 'Введите email' : 'Введите пароль'];
        }
    }

    if (isset($_POST['email']) && !in_array($_POST['email'], $emails)) {
        $errors += ['email' => 'Пользователя с таким e-mail не существует'];
    } else {
        $user_id = array_search($_POST['email'], $emails);
    }

    if (isset($_POST['password']) && in_array($_POST['email'], $emails)) {
        if (!password_verify($_POST['password'], $users[$user_id]['password'])) {
            $errors += ['password' => 'Неверный пароль'];
        }
    }

    if (count($errors) == 0) {
        $_SESSION['user'] = $users[$user_id];

        header('Location: /index.php');
    }
}

$main_content = renderTemplate('templates/login.php', [
    'errors' => $errors
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'user_avatar' => $user_avatar,
    'title' => 'Вход'
]);

print($layout_content);

