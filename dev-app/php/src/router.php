<?php
namespace RouterName;

// Импортируем Класы Controller и Model
require(CONFIG_ROOT_PATH.'/src/contoller.php');

use ControllerName\Controller;
use ModelName\Model;

/**
 * Класс Router
 *
 * @author Мамедов Вусал
 * @description Класс свзязующий все веб-приложение
 */
class Router {
	/**
	 * @constructor
	 * @description По умолчанию пусто, можно унаслвдовать данный класс
	 * @return Ничего не возвращает
	 */
	function __construct()
	{
		# code ...
	}

	/**
	 * Добавление страниц в роутер
	 *
	 * @param string $alias - Псеводоним (ЧПУ) страницы
	 * @param array $options - Массив с данными для роутинга
	 * @param array $options['render'] - Массив данных для рендера
	 * @param string $options['render']['filename'] - Название файла для рендера
	 * @param array $options['render']['options'] - Массив который будет принимать шаблонизатор 
	 * 												Twig в шаблоне
	 * @param string $options['app'] - Директория с приложеним
	 * @param string $options['file'] - Полный путь до файла, если указывается, то ключ render игнорируется
	 * @param string $options['title'] - Название сайта в мета-теге title
	 * @param array $options['description'] - Описание сайта в мета-теге description
	 * @param array $options['keywords'] - Ключевые слова сайта в мета-теге keywords
	 * @access public
	 * @return ничего не возвращает
	 * @see Model::$ROUTER_DATA
	 */
	public function router_add($alias, $options = null)
	{
		if (!array_key_exists($alias, Model::$ROUTER_DATA)) {
			Model::$ROUTER_DATA[$alias] = [
				'render' => $options['render'],
				'app' => $options['app'],
				'file' => $options['file'],
				'title' => $options['title'],
				'description' => $options['description'],
				'keywords' => $options['keywords']
			];
		}
	}

	/**
	 * Получение страницы по ЧПУ ссылке
	 *
	 * @param string $url - Псеводоним (ЧПУ) страницы
	 * @see Model::$ROUTER_DATA
	 * @access public
	 * @return Возвращает рендер html или указанный файл
	 */
	public function router_get($url)
	{
		$parse = parse_url($url);
		$Controller = new Controller();

		if (array_key_exists($parse['path'], Model::$ROUTER_DATA)) {
			if (isset(Model::$ROUTER_DATA[$parse['path']]['file']) && !empty(Model::$ROUTER_DATA[$parse['path']]['file'])) {
				$Controller->requireSystemFile(Model::$ROUTER_DATA[$parse['path']]['file']);
			} else {
				echo $Controller->getSystemTemp(Model::$ROUTER_DATA[$parse['path']]['app'], Model::$ROUTER_DATA[$parse['path']]['render']['filename'], Model::$ROUTER_DATA[$parse['path']]['render']['options']);
			}
		} else {
			header('HTTP/1.0 404 Not Found');
			echo '<h2>404 Not Found</h4>';
		}
	}
}