<?php

require_once 'functions.php';

$categories = [
    'Доски и лыжи',
    'Крепления',
    'Ботинки',
    'Одежда',
    'Инструменты',
    'Разное'
];

$main_content = renderTemplate('templates/add.php', [
    'errors' => [],
    'categories' => $categories,
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
        if (in_array($key, $required) && !$value) {
            $errors[] = $key;
        }

        if (in_array($key, $rules)) {
            $result = call_user_func('validateNumber', $value);

            if (!$result) {
                $errors[] = $key;
            }
        }
    }

    $image_url = '';

    if (isset($_FILES['image'])) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_name = $_FILES['image']['tmp_name'];
        $file_path = __DIR__ . '/img/';

        $file_type = finfo_file($finfo, $file_name);

        if ($file_type != 'image/jpeg' || $file_type != 'image/png') {
            $errors[] = 'image';
        }

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $image_url = '/img/' . $_FILES['image']['name'];

            move_uploaded_file($file_name, $file_path . $_FILES['image']['name']);
        }
    }

    if (count($errors) == 0) {
        $main_content = renderTemplate('templates/lot.php', [
            'bets' => [],
            'lot' => [
                'title' => $_POST['lot-name'],
                'category' => $_POST['category'],
                'description' => $_POST['message'],
                'price' => $_POST['lot-rate'],
                'image_url' => $image_url
            ]
        ]);
    } else {
        $main_content = renderTemplate('templates/add.php', [
            'errors' => $errors,
            'categories' => $categories,
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
