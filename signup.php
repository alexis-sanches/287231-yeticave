<?php
require_once 'functions.php';
require_once 'init.php';

function validateEmail($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}
$errors = [];

$required = ['email', 'password', 'name', 'message'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && !$value) {
            $errors += [$key => 'Это поле должно быть заполнено'];
        }

        if ($key == 'email') {
            $result = call_user_func('validateEmail', $value);

            if (!$result) {
                $errors += [$key => 'Введите правильный email'];
            } else {
                $query_result = selectFromDatabase($con, 'SELECT * FROM users WHERE email = ?', [$value]);

                if (count($query_result) != 0) {
                    $errors += [$key => 'Пользователь с таким e-mail уже существует'];
                }
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
            $errors += ['image' => 'Неправильный формат изображения'];
        }

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $image_url = '/img/' . $_FILES['image']['name'];

            move_uploaded_file($file_name, $file_path . $_FILES['image']['name']);
        }
    }

    if (count($errors) == 0) {
        $now = date('Y-m-d H:i:s', strtotime('now'));
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $values = [
            'created_at' => $now,
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'password' => $password_hash,
            'image_url' => $image_url,
            'contacts' => $_POST['message']
        ];

        insertIntoDatabase($con, 'users', $values);

        header('Location: /login.php');
    }
}

$main_content = renderTemplate('templates/signup.php', [
    'errors' => $errors,
    'categories_layout' => $categories_layout,
]);

$layout_content = renderTemplate('templates/layout.php', [
    'main_content' => $main_content,
    'categories_layout' => $categories_layout,
    'title' => 'Регистрация'
]);

print($layout_content);



