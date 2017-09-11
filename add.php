<?php

require_once 'functions.php';
//require_once 'lot.php';

$main_content = renderTemplate('templates/add.php', [
    'errors' => $errors
]);


function validateNumber($value) {
    return filter_var($value, FILTER_VALIDATE_INT);
}

$required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
$rules = [
    'lot-rate' => 'validateNumber',
    'lot-step' => 'validateNumber'
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && $value = '') {
            $errors[] = $key;
            break;
        }

        if (in_array($key, $rules)) {
            $result = call_user_func('validateNumber', $value);

            if (!$result) {
                $errors[] = $key;
            }
        }
    }

    if (is_uploaded_file($_FILES['image'])) {
        move_uploaded_file($_FILES['image'], 'img/');
    }

    if (count($errors) == 0) {
        header('Location: /add.php?success=true');
    }

    if (isset($_GET['success'])) {
        $main_content = renderTemplate('templates/lot.php', [
            'bets' => [],
            'lot' => [
                'title' => $_POST['lot-name'],
                'category' => $_POST['category'],
                'description' => $_POST['message'],
                'price' => $_POST['lot-rate'],
            ]
        ]);
    }
}

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'title' => 'Добавление лота'
]);

print($layout_content);
