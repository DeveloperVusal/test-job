<?php
namespace MySQLName;

/**
 * Класс MySQL
 *
 * @author Мамедов Вусал
 * @description Класс для работы с соединениями к MySQL
 */
class MySQL
{
	public static $mysqli;

	/**
	 * Метод подключения к БД MySql
	 * 
	 * @access public
	 * @description Статичечский метод 
	 * @return Ничего не возвращает, кроме как может вернуть ошибку
	 */
	public static function iConnect()
	{
		self::$mysqli = new \mysqli(CONFIG_SERV_HOST, CONFIG_SERV_USER, CONFIG_SERV_PASS, CONFIG_SERV_DBNAME);

		if (self::$mysqli->connect_error) {
			die('Ошибка подключения ('.self::$mysqli->connect_errno.') '.self::$mysqli->connect_error);
		}

		self::$mysqli->set_charset('utf8');
	}

	/**
	 * Метод  завершения подключения к БД MySql
	 * 
	 * @access public
	 * @description Статичечский метод 
	 * @return Ничего не возвращает, выводит сообщение на экране
	 */
	public static function iClose()
	{
		if (!self::$mysqli->close()) {
			print_r('Соединение не закрыто!');
		}
	}
}