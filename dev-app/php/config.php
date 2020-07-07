<?php
/* Условие от доступа к файлу */
if(!defined('READFILE')) {
	header('HTTP/1.0 404 Not Found');
	echo '<h2>404 Not Found</h4>';
	exit;
}

/* Данные для работы с БД MySql */
define('CONFIG_SERV_TYPE', 'MYSQL');
define('CONFIG_SERV_HOST', 'localhost');
define('CONFIG_SERV_USER', 'mysql');
define('CONFIG_SERV_PASS', 'mysql');
define('CONFIG_SERV_DBNAME', 'todo_test');

/* Вывод ошибок */
define('CONFIG_WEB_ERRORS', true);

/* Вывод ошибок */
define('CONFIG_ROOT_PATH', str_replace('\\', '/', __DIR__));
?>