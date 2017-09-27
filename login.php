<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST as $key => $value) {
        if (!$value) {
            $errors += [$key => $key == 'email' ? 'Введите email' : 'Введите пароль'];
        }
    }

    $users = selectFromDatabase($con, 'SELECT * FROM users WHERE email = ?', [$_POST['email']]);

    if (count($users) == 0) {
        $errors += ['email' => 'Пользователя с таким e-mail не существует'];
    }

    if (isset($_POST['password']) && count($users) != 0) {
        if (!password_verify($_POST['password'], $users[0]['password'])) {
            $errors += ['password' => 'Неверный пароль'];
        }
    }

    if (count($errors) == 0) {
        $_SESSION['user'] = $users[0];
        header('Location: /index.php');
    }
}

$main_content = renderTemplate('templates/login.php', [
    'categories_layout' => $categories_layout,
    'errors' => $errors,
    'message' => ''
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'categories_layout' => $categories_layout,
    'title' => 'Вход'
]);

print($layout_content);

