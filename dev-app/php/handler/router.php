<?php
use RouterName\Router;

// Вызываем Роутер для добавляения ссылок для дальней работы
$Router = new Router();

// Добавляем в рендер и роутинг MVC наше SPA приложение
$Router->router_add('/', [
	'render' => [
		'filename' => 'index.html',
		'options' => []
	],
	'app' => 'build-app',
	'title' => 'Это Todo приложение'
]);

// В данном приложение мы будет работать с RESEN API
// Следовательно будет указывать alias и path (полный путь до папки)

// Добавление
$Router->router_add('/api/post_add', [
	'file' => CONFIG_ROOT_PATH.'/apis/post-add.php'
]);

// Удаление
$Router->router_add('/api/post_delete', [
	'file' => CONFIG_ROOT_PATH.'/apis/post-delete.php'
]);

// Вывод публикаций
$Router->router_add('/api/get_posts', [
	'file' => CONFIG_ROOT_PATH.'/apis/get-posts.php'
]);

// Поиск публикаций
$Router->router_add('/api/search_posts', [
	'file' => CONFIG_ROOT_PATH.'/apis/search-posts.php'
]);
?>