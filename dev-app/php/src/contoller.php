<?php
namespace ControllerName;

require(CONFIG_ROOT_PATH.'/src/view.php');

use ViewName\View;
use ModelName\Model;

class Controller {
	/**
	 * Получает указанную директорию
	 *
	 * @param string $filename - Название .html файла в директории templ
	 * @param string $options - Массив с данными для .html
	 * @access public
	 * @return Возвращает рендер html
	 */
	public function getSystemTemp($filename, $options = null)
	{
		$View = new View();
		return $View->renderTwigFile($filename, $options);
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

	/**
	 * Получает указанную директорию
	 *
	 * @param string $pathfile - Абсолютный путь к файлу
	 * @access public
	 * @return Возвращает массив данных
	 */
	/*public function userSystemAuth($obj = [])
	{	
		$Model = new Model();

		return $Model->system_userAuth([
			'value' => $obj['login'],
			'password' => $obj['password'],
		]);
	}*/
}
?>