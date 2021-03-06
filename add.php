<?php
require_once 'functions.php';
require_once 'mysql_helper.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

ini_set('display_errors', 'On');

$required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
$rules = [
    'lot-rate' => 'validateNumber',
    'lot-step' => 'validateNumber',
    'lot-date' => 'validateDate'
];
$errors = [];

/**
 * Проверяет, что было передано число
 *
 * @param $value - пользовательский ввод
 *
 * @return boolean - результат проверки
 */

function validateNumber($value) {
    return filter_var($value, FILTER_VALIDATE_INT) && $value > 0;
}

/**
 * Проверяет, что была передана дата не меньше, чем полночь завтрашнего дня
 *
 * @param $value - пользовательский ввод
 *
 * @return boolean - результат проверки
 */

function validateDate($value) {
    return strtotime($value) >= strtotime('tomorrow midnight');
}

if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $key => $value) {
            if (in_array($key, $required) && !$value) {
                $errors[] = $key;
            }

            if (in_array($key, $rules)) {
                $result = call_user_func($rules[$key], $value);

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

            if ($file_type != 'image/jpeg' && $file_type != 'image/png' && $file_type != 'image/jpg') {
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
                'price' => $_POST['lot-rate'],
                'finished_at' => $finished_at,
                'bet_step' => $_POST['lot-step'],
                'likes' => 0,
                'author_id' => $_SESSION['user']['id'],
                'category_id' => $_POST['category']
            ];

            $id = insertIntoDatabase($con, 'lots', $values);
            header('Location: /lot.php?lot=' . $id);
        }
    }

    $main_content = renderTemplate('templates/add.php', [
        'errors' => $errors,
        'categories' => $categories,
        'categories_layout' => $categories_layout
    ]);

    $layout_content = renderTemplate('templates/layout.php', [
        'main_content' => $main_content,
        'categories_layout' => $categories_layout,
        'title' => 'Добавление лота'
    ]);

    print($layout_content);

} else {
    http_response_code(403);
    exit();
}

