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
	// В данной публичной переменной будут хранится все страницы добавленые
	// с помощью метода router_add() в классе Router
	public static $ROUTER_DATA = [];

	/**
	 * @constructor
	 * @method Вызывает метод {system_init}
	 * @access public
	 * @return Ничего не возвращает
	 */
	function __construct()
	{
		# Your code ...
	}

	
	/**
	 * Генерация CSRF токена
	 *
	 * @param string $sesion_name - Ключ сессии
	 * @access public
	 * @return Возвращает хэш из случайной строки и сохраняет в сесиию 'token_csrf' (если она включена)
	 */
	public function system_generateCSRF($sesion_name = 'token_csrf')
	{
		session_start();
		
		$hash = hash('sha256', $this->system_generateCode('chars', 65));
		$_SESSION[$sesion_name] = $hash;
		return $hash;
	}

	/**
	 * Генерация случайной строки
	 *
	 * @param string $type - Тип гереации chars or int. По умолчанию: chars
	 * @param int $length - Длина случайной строки. По умолчанию: 6
	 * @access public
	 * @return Возвращает случаную строку
	 */
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