<?php
namespace ModelName;

// Подключаем Класс для работы с соединениями с БД
use MySQLName\MySQL;

/**
 * Класс Model MVC структуры
 *
 * @author Мамедов Вусал
 * @description Ядро для работы Веб-приложения
 */
class Model
{	
	public static $ROUTER_DATA = [];

	
	function __construct()
	{
		$this->system_init();
	}

	public function system_init() {
		# code ...
	}
	
	public function system_generateCSRF()
	{
		$_SESSION['token_csrf'][$_SERVER['REQUEST_URI']] = hash('sha256', $this->system_generateCode('chars', 65));
		return $_SESSION['token_csrf'][$_SERVER['REQUEST_URI']];
	}

	public function system_getRealIp()
	{
		if (isset($_SERVER)) {
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		} else {
			if (getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
				$ip = getenv( 'HTTP_X_FORWARDED_FOR' );
			} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
				$lip = getenv( 'HTTP_CLIENT_IP' );
			} else {
				$ip = getenv( 'REMOTE_ADDR' );
			}
		}
		return $ip;
	}

	public static function system_getDomianUrl()
	{
		if (isset($_SERVER['HTTPS'])){
			$scheme = $_SERVER['HTTPS'];
		} else {
			$scheme = '';
		}

		if (($scheme) && ($scheme != 'off')) $scheme = 'https';
		else $scheme = 'http';
		return $scheme.'://'.$_SERVER['SERVER_NAME'];
	}

	public function system_generateCode($type = 'chars', $length = 6)
	{
		if ($type == 'chars') {
			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
			$code = '';
			$clen = strlen($chars) - 1;

			while (strlen($code) < $length) {
				$code .= $chars[mt_rand(0, $clen)];
			}
		} elseif ($type == 'int') {
			$chars = '0123456789';
			$code = '';
			$clen = strlen($chars) - 1;

			while (strlen($code) < $length) {
				$code .= $chars[mt_rand(0, $clen)];
			}
		}

		return $code;
	}

	function __destruct()
	{
		# code ...
	}
}
?>