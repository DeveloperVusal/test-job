<?php
header('Content-Type: application/json');
session_start();

// Импортируем нужны классы для работы
use HandlerName\HandlerDB;
use ModelName\MyModel;
use MySQLName\MySQL;

// Так просто не получить JSON данные, поэтому будем использовать такой алгоритм
$postJson = file_get_contents('php://input');
$postData = json_decode($postJson, true);

// Проверяем был отправлен токен CSRF
if (isset($postData['csrf']) && iconv_strlen($postData['csrf']) > 30) {
    // Сравниваем токены
    if ($postData['csrf'] === $_SESSION['token_csrf']) {
        $handlerDB = new HandlerDB(); // Создаем объект класса обработчика БД

        $sel = $handlerDB->iBaseQuery("SELECT * FROM `todos` WHERE `title` LIKE '%".$handlerDB::sql_injection($postData['value'])."%' OR `text` LIKE '%".$handlerDB::sql_injection($postData['value'])."%'");
        
        $items = [];

        while ($row = $sel->fetch_assoc()) {
            $items[] = $row;
        }

        exit(json_encode([
            'type' => 'success',
            'message' => 'Data successfully received',
            'response' => $items
        ]));
    } else {
        exit(json_encode([
            'type' => 'error',
            'message' => 'Invalid token CSRF'
        ]));
    }
} else {
    exit(json_encode([
        'type' => 'error',
        'message' => 'Empty requset CSRF'
    ]));
}
exit;
?>