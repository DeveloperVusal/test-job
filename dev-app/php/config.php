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
define('CONFIG_SERV_USER', 'cm47623_infomer');
define('CONFIG_SERV_PASS', '3C9uKweC1Q@1aK');
define('CONFIG_SERV_DBNAME', 'cm47623_infomer');

/* Вывод ошибок */
define('CONFIG_WEB_ERRORS', true);

/* Вывод ошибок */
define('CONFIG_ROOT_PATH', str_replace('\\', '/', __DIR__));

/* Версия Фреймворка */
define('CONFIG_VERSION', '0.0.1');

/* Соль для хэшей */
define('CONFIG_SALT_KEY', 'Z8CWnPx1*s&^');
define('CONFIG_SALT_PASSWORD', 'r$1qWa0%D*/lk#');
?>