<?php
require_once 'functions.php';
require_once 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'yeticave';

$con = mysqli_connect($host, $username, $password, $database);
mysqli_set_charset($con, 'utf8');

if ($con == false) {
    $error = mysqli_connect_error();

    $main_content = renderTemplate('templates/error.php', [
        'error' => $error
    ]);

    $layout_content = renderTemplate('templates/layout.php', [
        'main_content' => $main_content,
        'title' => 'Ошибка подключения к БД'
    ]);

    print($layout_content);
    exit();
}

$categories = selectFromDatabase($con, 'SELECT * FROM categories');

$categories_layout = renderTemplate('templates/categories.php', [
    'categories' => $categories
]);
