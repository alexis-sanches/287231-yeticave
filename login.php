<?php
require_once 'functions.php';
require_once 'userdata.php';

session_start();

$user_avatar = 'img/user.jpg';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function getEmails($arr) {
        return $arr['email'];
    }

    $emails = array_map('getEmails', $users);

    foreach ($_POST as $key => $value) {
        if (!$value) {
            $errors[] = $key;
            break;
        }
    }

    if (!in_array($_POST['email'], $emails)) {
        $errors[] = 'email';
    } else {
        $user = array_search($_POST['email'], $emails);
    }

    if ($_POST['password'] && isset($user, $users)) {
        if (!password_verify($_POST['password'], $users[$user]['password'])) {
            $errors[] = 'password';
        }
    }

    if (count($errors) == 0) {
        $template_data = [
            'errors' => $errors
        ];

        $_SESSION['user'] = $users[$user];

        header('Location: /index.php');
    } else {
        $template_data = [
            'errors' => $errors,
        ];
    }
} else {
    $template_data = [
        'errors' => [],
    ];
}

$main_content = renderTemplate('templates/login.php', $template_data);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'user_avatar' => $user_avatar,
    'title' => 'Вход'
]);

print($layout_content);

