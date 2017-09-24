<?php

session_start();

$user_avatar = 'img/user.jpg';

require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';

$categories = selectFromDatabase($con, 'SELECT * FROM categories');

function validateNumber($value) {
    return filter_var($value, FILTER_VALIDATE_INT);
}

$required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
$rules = [
    'lot-rate' => 'validateNumber',
    'lot-step' => 'validateNumber'
];
$errors = [];

if (isset($_SESSION['user'])) {
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

        if (isset($_FILES['image']) && UPLOAD_ERR_OK == $_FILES['image']['error']) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_name = $_FILES['image']['tmp_name'];
            $file_path = __DIR__ . '/img/';

            $file_type = finfo_file($finfo, $file_name);

            if ($file_type != 'image/jpeg' && $file_type != 'image/png') {
                $errors[] = 'image';
            }

            if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                $image_url = '/img/' . $_FILES['image']['name'];

                move_uploaded_file($file_name, $file_path . $_FILES['image']['name']);
            }
        }

        if (count($errors) == 0) {
            $now = date('Y-m-d H:i:s', strtotime('now'));
            $finished_at = date('Y-m-d H:i:s', strtotime($_POST['lot-date']));
            $values = [
                'created_at' => $now,
                'title' => $_POST['lot-name'],
                'description' => $_POST['message'],
                'image_url' => $image_url,
                'price' => intval($_POST['lot-rate']),
                'finished_at' => $finished_at,
                'bet_step' => intval($_POST['lot-step']),
                'likes' => 0,
                'author_id' => $_SESSION['user']['id'],
                'category_id' => intval($_POST['category'])
            ];

            $id = insertIntoDatabase($con, 'lots', $values);
            header('Location: /lot.php?lot=' . $id);
        }
    }

    $main_content = renderTemplate('templates/add.php', [
        'errors' => $errors,
        'categories' => $categories
    ]);

    $layout_content = renderTemplate('templates/layout.php', [
        'main_content' => $main_content,
        'categories' => $categories,
        'title' => 'Добавление лота'
    ]);

    print($layout_content);

} else {
    http_response_code(403);
    exit();
}

