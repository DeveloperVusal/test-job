<?php
use RouterName\Router;

// Вызываем Роутер для добавляения ссылок для дальней работы
$Router = new Router();

// В данном приложение мы будет работать с RESEN API
// Следовательно будет указывать alias и path (полный путь до папки)

// Добавление
$Router->router_add('/post_add', [
	'file' => CONFIG_ROOT_PATH.'/dev-app/php/apis/post-add.php'
]);

// Удаление
$Router->router_add('/post_delete', [
	'file' => CONFIG_ROOT_PATH.'/dev-app/php/apis/post-delete.php'
]);

// Редактирование
$Router->router_add('/post_edit', [
	'file' => CONFIG_ROOT_PATH.'/dev-app/php/apis/post-edit.php'
]);

// Вывод публикаций
$Router->router_add('/get_posts', [
	'file' => CONFIG_ROOT_PATH.'/dev-app/php/apis/get-posts.php'
]);

// Поиск публикаций
$Router->router_add('/search_posts', [
	'file' => CONFIG_ROOT_PATH.'/dev-app/php/apis/search-posts.php'
]);
?>