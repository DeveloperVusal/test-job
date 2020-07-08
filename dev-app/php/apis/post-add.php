<?php
header('Content-Type: application/json');

session_start();

// Импортирует нужны классы для работы
use HandlerName\HandlerDB;
use ModelName\MyModel;
use MySQLName\MySQL;

$postJson = file_get_contents('php://input');
$postData = json_decode($postJson, true);

if (isset($postData['csrf']) && iconv_strlen($postData['csrf']) > 30) {
    if ($postData['csrf'] === $_SESSION['token_csrf']) {
        $handlerDB = new HandlerDB();

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