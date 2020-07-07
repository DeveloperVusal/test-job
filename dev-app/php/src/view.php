<?php
namespace ViewName;
use ModelName\Model;

require_once CONFIG_ROOT_PATH.'/system/Twig/vendor/autoload.php';

class View {
	/**
	 * Получает указанную директорию
	 *
	 * @param string $filename - Название .html файла в директории templ
	 * @param string $options - Массив с данными для .html
	 * @access public
	 * @return Возвращает рендер html
	 */
	public function renderTwigFile($app, $filename, $options = null) {
		$loader = new \Twig\Loader\FilesystemLoader(CONFIG_ROOT_PATH.'/apps/'.$app);
		$twig = new \Twig\Environment($loader, [
		    //'cache' => CONFIG_ROOT_PATH.'/system/Twig/compilation_cache',
		    'cache' => false,
		    'auto_reload' => true,
		]);

		$options['dirname'] = '/apps/'.$app;
		$options['version'] = CONFIG_VERSION;
		$Model = new Model();
		$options['token_csrf'] = $Model->system_generateCSRF();

		return $twig->render($filename, $options);
	}
}
?>