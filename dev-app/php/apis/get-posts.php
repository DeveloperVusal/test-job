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

        $sel = $handlerDB->iSelectTable([
            'table-name' => 'todos'
        ]);
        
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