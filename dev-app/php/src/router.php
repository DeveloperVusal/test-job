<?php
namespace RouterName;

require(CONFIG_ROOT_PATH.'/src/contoller.php');

use ControllerName\Controller;
use ModelName\Model;

class Router {
	public $WEB_PAGES = [];

	function __construct()
	{
		# code ...
	}

	public function router_add($alias, $options = null)
	{
		if (!array_key_exists($alias, Model::$ROUTER_DATA)) {
			Model::$ROUTER_DATA[$alias] = [
				'render' => $options['render'],
				'app' => $options['app'],
				'file' => $options['file'],
				'title' => $options['title'],
				'description' => $options['description'],
				'keywords' => $options['keywords'],
				'alpha' => $options['alpha']
			];
		}
	}

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