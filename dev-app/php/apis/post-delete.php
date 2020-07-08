<?php
header('Content-Type: application/json');
session_start();

// Импортирует нужны классы для работы
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

        $del = $handlerDB->iDeleteTable([
            'table-name' => 'todos',
            'where' => [
                [
                    'field' => 'id',
                    'value' => (int)$postData['post_id']
                ]
            ]
        ]);

        if ($del) {
            exit(json_encode([
                'type' => 'success',
                'message' => 'Post deleted'
            ]));
        } else {
            exit(json_encode([
                'type' => 'error',
                'message' => 'Error not deleted'
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