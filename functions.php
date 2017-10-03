<?php
require_once 'mysql_helper.php';
require_once 'vendor/autoload.php';

/**
 * Отображает на странице содержимое шаблона
 *
 * @param $path string - Путь к php-файлу шаблона
 * @param $arr array - Массив с данными для шаблона
 *
 * @return string - Содержимое шаблона со всеми вставленными значениями
 */

function renderTemplate($path, $arr) {
    if (!file_exists($path)) {
        return '';
    }

    extract($arr, EXTR_SKIP);

    ob_start();
    require_once($path);
    $content = ob_get_clean();

    return $content;
}

/**
 * Выводит время относительно текущей временной метки
 *
 * @param $ts number - Временная метка
 *
 * @return string - Дата в одном из трёх форматов
 */

function getRelativeDate($ts) {
    $current_time = strtotime('now');
    $time_left = $current_time - $ts;
    $hour = 3600;
    $day = 86400;

    if ($time_left >= $day) {
        return date("d.m.Y H:i", $ts);
    } elseif ($time_left >= $hour) {
        return floor($time_left / 3600) . ' часов назад';
    } else {
        return floor($time_left / 60) . ' минут назад';
    }
}

/**
 * Выполняет запрос на получение значений из БД
 *
 * @param $connect mysqli - Ресурс соединения
 * @param $query string - SQL-запрос
 * @param $values array - Значения для подготовленного выражения
 *
 * @return array - Результат работы запроса
 */

function selectFromDatabase($connect, $query, $values = []) {
    $stmt = db_get_prepare_stmt($connect, $query, $values);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $query_res = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($query_res, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

/**
 * Выполняет запрос на добавление значений в БД
 *
 * @param $connect mysqli - Ресурс соединения
 * @param $table string - Название таблицы
 * @param $values array - Значения для подготовленного выражения
 *
 * @return boolean | number - False, если запрос завершился с ошибкой, id последней записи в ином случае
 */

function insertIntoDatabase($connect, $table, $values) {
    $keys = array_keys($values);
    $vals = array_values($values);
    $placeholders = array_fill(0, count($keys), '?');

    $keys_str = implode(', ', $keys);
    $values_str = implode(', ', $placeholders);

    $query = 'INSERT INTO ' . $table . '(' . $keys_str . ') VALUES (' . $values_str .  ')';

    $stmt = db_get_prepare_stmt($connect, $query, $vals);

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        return false;
    }

    return mysqli_insert_id($connect);
}

/**
 * Выполняет случайный запрос к БД через подготовленные выражения
 *
 * @param $connect mysqli - Ресурс соединения
 * @param $query string - SQL-запрос
 * @param $values array - Значения для подготовленного выражения
 *
 * @return boolean - результат выполнения подготовленного выражения
 */

function randomQuery($connect, $query, $values = []) {
    $stmt = db_get_prepare_stmt($connect, $query, $values);

    return mysqli_stmt_execute($stmt);
}

/**
 * Отправляет email через библиотеку SwiftMailer
 *
 * @param $email string - Email получателя
 * @param $name string - Имя получателя
 * @param $lot_id int - Номер лота
 * @param $lot_name string - Название лота
 */

function sendEmail($email, $name, $lot_id, $lot_name) {
    $body = renderTemplate('templates/email.php', [
        'username' => $name,
        'email' => $email,
        'id' => $lot_id,
        'lot_name' => $lot_name
    ]);

    $transport = (new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
        -> setUsername('doingsdone@mail.ru')
        -> setPassword('rds7BgcL');

    $message = (new Swift_Message('Ваша ставка победила'))
        -> setTo([$email => $name])
        -> setContentType('text/html')
        -> setBody($body)
        -> setFrom(['doingsdone@mail.ru' => 'YetiCave']);

    $mailer = (new Swift_Mailer($transport));
    $mailer -> send($message);
}