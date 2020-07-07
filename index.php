<?php
// Прочие настройеи веб-приложения
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Content-type: text/html; charsetr=utf-8');

define ('READFILE', true);

// Подключаем config файл для дальней работы
require_once('dev-app/php/config.php');

// Выводим ошибки, если они имеются
if (CONFIG_WEB_ERRORS == true) {
	ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}

// Подключаем специальные классы (MVC) для работы веба
require_once('dev-app/php/src/router.php');
require_once('dev-app/php/src/mysql.php');
require_once('dev-app/php/src/model.php');
require_once('dev-app/php/extends/model.php');

use ModelName\Model;
use MyModelName\MyModel;
use RouterName\Router;

require_once('dev-app/php/handler/router.php');

// Получаем специальные модули для расширения web из директории modules
$dirs = array_slice(scandir('dev-app/php/modules'), 2);

if (sizeof($dirs)) {
	for ($i = 0; $i < count($dirs); $i++) {
		if (file_exists('dev-app/php/modules/'.$dirs[$i].'/init.php')) {
			include_once 'dev-app/php/modules/'.$dirs[$i].'/init.php';
		}
	}
}

$Router = new Router();
$Router->router_get($_SERVER['REQUEST_URI']);
?>