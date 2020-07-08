<?php
namespace ViewName;

// Импортируем Клас Model
use ModelName\Model;

// Импортируем Лодаер Composer'а, откуда импортируем шаблонизатор Twig
require_once CONFIG_ROOT_PATH.'/system/vendor/autoload.php';

/**
 * Класс View MVC структуры
 *
 * @author Мамедов Вусал
 * @description Класс для работы с UI веб-проекта
 */
class View {
	/**
	 * С помощью шаблонизатора Twig рендерим нужные данные
	 *
	 * @param string $app - Директория с приложением
	 * @param string $filename - Название .html файла в директории @app
	 * @param array $options - Массив с данными для .html
	 * @access public
	 * @return Возвращает рендер html
	 */
	public function renderTwigFile($app, $filename, $options = null) {
		$pathinfo = pathinfo(CONFIG_ROOT_PATH);
		$dirs = explode('/', $pathinfo['dirname']);
		$dirname = array_splice($dirs, 0, sizeof($dirs) - 1);
		$dirname = implode('/', $dirname);

		$loader = new \Twig\Loader\FilesystemLoader($dirname.'/'.$app);
		$twig = new \Twig\Environment($loader, [
		    //'cache' => CONFIG_ROOT_PATH.'/system/Twig/compilation_cache',
		    'cache' => false,
		    'auto_reload' => true,
		]);

		$options['dirname'] = '/'.$app;
		$Model = new Model();
		$options['token_csrf'] = $Model->system_generateCSRF();

		return $twig->render($filename, $options);
	}
}
?>