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
        if (iconv_strlen($postData['title']) && iconv_strlen($postData['text'])) {
            $handlerDB = new HandlerDB(); // Создаем объект класса обработчика БД

            $ins = $handlerDB->iInsertTable('todos', [
                'title' => $postData['title'],
                'text' => $postData['text'],
                'date' => '###:NOW()'
            ]);
            
            $ID = MySQL::$mysqli->insert_id;

            if ($ins) {
                exit(json_encode([
                    'type' => 'success',
                    'message' => 'Successfully added',
                    'response' => [
                        'id' => $ID,
                        'title' => $postData['title'],
                        'text' => $postData['text'],
                        'date' => $handlerDB->iGetTableData('todos', $ID, 'id', 'date')
                    ]
                ]));
            } else {
                exit(json_encode([
                    'type' => 'error',
                    'message' => 'Error not added'
                ]));
            }
        } else {
            exit(json_encode([
                'type' => 'warning',
                'message' => 'Empty fields'
            ]));
        }
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