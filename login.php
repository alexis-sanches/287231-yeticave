<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

session_start();

$errors = [];

$categories = selectFromDatabase($con, 'SELECT * FROM categories');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST as $key => $value) {
        if (!$value) {
            $errors += [$key => $key == 'email' ? 'Введите email' : 'Введите пароль'];
        }
    }

    $emails = selectFromDatabase($con, 'SELECT * FROM users WHERE email = ?', [$_POST['email']]);

    if (count($emails) == 0) {
        $errors += ['email' => 'Пользователя с таким e-mail не существует'];
    } else {
        $user_id = $emails[0]['id'];
    }

    if (isset($_POST['password']) && count($emails) != 0) {
        if (!password_verify($_POST['password'], $emails[0]['password'])) {
            $errors += ['password' => 'Неверный пароль'];
        }
    }

    if (count($errors) == 0) {
        $query = 'SELECT * FROM users WHERE email = ?';
        $_SESSION['user'] = $emails[0];

        header('Location: /index.php');
    }
}

$main_content = renderTemplate('templates/login.php', [
    'categories' => $categories,
    'errors' => $errors
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'categories' => $categories,
    'title' => 'Вход'
]);

print($layout_content);

