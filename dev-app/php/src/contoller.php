<?php
namespace ControllerName;

require(CONFIG_ROOT_PATH.'/src/view.php');

use ViewName\View;
use ModelName\Model;

/**
 * Класс Controller MVC структуры
 *
 * @author Мамедов Вусал
 * @description Этот класс является как шлюзом, где можно написать отдельную логику, 
 * дабы не трогать View или Model
 */
class Controller {
	/**
	 * Метод получения рендера шаблона веб проекта
	 *
	 * @param string $app - Директория с приложением
	 * @param string $filename - Название .html файла в директории @app
	 * @param array $options - Массив с данными для .html
	 * @access public
	 * @return Возвращает рендер html
	 */
	public function getSystemTemp($app, $filename, $options = null)
	{
		$View = new View();
		return $View->renderTwigFile($app, $filename, $options);
	}

	/**
	 * Получает указанную директорию
	 *
	 * @param string $pathfile - Абсолютный путь к файлу
	 * @access public
	 * @return Возвращает массив данных
	 */
	public function requireSystemFile($pathfile)
	{
		require($pathfile);
	}
}
?>