<?php
namespace HandlerName;

// Импортируем класс для связи с БД
use MySQLName\MySQL;

/**
 * Модульный класс для работы с БД
 *
 * @author Мамедов Вусал
 */
class HandlerDB
{
	/**
	 * @constructor
	 * @method Вызывает метод {Init}
	 * @see MySQL::iConnect()
	 * @return Ничего не возвращает
	 */
	function __construct()
	{
		MySQL::iConnect();
		$this->Init();
	}

	/**
	 * Метод инициализации
	 * 
	 * @method Вызывает метод {createDefaultTables}
	 * @access public
	 * @return Ничего не возвращает
	 */
	public function Init()
	{
		$this->createDefaultTables();
	}

	/**
	 * Создания таблиц
	 * 
	 * @access private
	 * @see MySQL::$mysqli->query
	 * @return Ничего не возвращает
	 */
	private function createDefaultTables()
	{
		$q = MySQL::$mysqli->query("CREATE TABLE IF NOT EXISTS `todos` 
									(`id` INT PRIMARY KEY AUTO_INCREMENT,
									 `title` VARCHAR(255),
									 `text` TEXT,
									 `date` DATETIME
									);");

		if (!$q) print_r('Таблица "todos" не создана.<br>');
	}

	/**
	 * Метод добавления записей в таблицы
	 * 
	 * @param string $table_name - Имя таблицы
	 * @param array $arr - Ассоциативный массив (key - название поля, value - значение поля)
	 * @access public
	 * @method Вызывается метод {sql_injection}
	 * @return Возвращает sql ответ
	 */
	public function iInsertTable($table_name, $arr = [])
	{
		$sql = "INSERT INTO `".$table_name."` (";

		foreach ($arr as $key => $val) {
			if (!empty($key)) $sql .= "`".self::sql_injection($key)."`,";
		}

		$sql = substr($sql, 0, -1).') VALUES(';

		foreach ($arr as $key => $val) {
			if (!empty($key)) {
				if (strstr($val, '###:')) {
					$val = self::sql_injection(str_replace('###:', '', $val));
					$sql .= $val.",";
				} else {
					$sql .= "'".self::sql_injection($val)."',";
				}
			}
		}

		$sql = substr($sql, 0, -1).')';
		$query = MySQL::$mysqli->query($sql);

		if ($query) {
			return $query;
		} else {
			if (!MySQL::$mysqli->error) {
				die('<b>Строка:</b> '.__LINE__.'<br/><b>Запрос:</b> '.$sql.'<br/><b>Ошибка:</b> '.MySQL::$mysqli->error);
			}
		}
	}

	/**
	 * Метод получет одну запись из таблицы
	 * 
	 * @param string $table_name - Название таблицы
	 * @param string|int $value - Значение сверямого поля (столбца)
	 * @param string $key_field - Сверяемое поле (столбец)
	 * @param string $field - Возвращаемое поле (столбец)
	 * @param boolean $ech - Выводит на экран или вернуть. По умолчанию: false
	 * @access public
	 * @method Вызывается метод {iSelectTable}
	 * @return Ничего не возвращает
	 */
	public function iGetTableData($table_name, $value, $key_field, $field, $ech = false)
	{
		$sel = $this->iSelectTable([
			'table-name' => $table_name,
			'where' => [
				[
					'field' => $key_field,
					'value' => $value
				]
			],
			'select-fields' => [$field]
		]);
		if ((int)$sel->num_rows) {
			$obj = $sel->fetch_object();

			if ($ech == true) {
				echo $obj->{$field};
			} else {
				return $obj->{$field};
			}
		} else {
			return false;
		}
	}

	/**
	 * Метод выборки записей из таблицы
	 * 
	 * @param array $arr - Ассоциативный массив
	 * @param string $arr['table-name'] - Имя таблицы
	 * @param array $arr['where'] - Индексный массив, принимает в себя ассоциативный массив
	 * @param array $arr['where'] - Индексный массив, принимает в себя ассоциативный массив
	 * @example 'where' => [
	 * 	[ 'field_1' => {field_name}, 'value_2' => {field_value} ],
	 * 	[ 'field_2' => {field_name}, 'value_2' => {field_value} ]
	 * ]
	 * @param array $arr['select-fields'] - Индексный массив с названиями полей
	 * @param string $arr['others'] - Другие условия выборки такие как ORDER BY, LIMIT и прочее
	 * @access public
	 * @method Вызывается метод {sql_injection}
	 * @return Возвращает sql ответ
	 */
	public function iSelectTable($arr = [])
	{
		$sql = "SELECT";

		if (sizeof($arr['select-fields'])) {
			$sql .= ' ';
			$fields = '';

			foreach ($arr['select-fields'] as $key => $val) {
				if (strstr($val, '###:')) {
					$val = str_replace('###:', '', $val);
					$fields .= self::sql_injection($val).',';
				} else {
					$fields .= '`'.self::sql_injection($val).'`,';
				}
			}
			$fields = substr($fields, 0, -1);
			$sql .= ' '.$fields;
		} else {
			$sql .= " *";
		}

		$sql .= " FROM `".$arr['table-name']."`";

		if (sizeof($arr['where'])) {
			$sql .= " WHERE";

			foreach ($arr['where'] as $key => $val) {
				if ($key > 0) {
					if (isset($val['operator']) && !empty($val['operator'])) {
						$sql .= " ".$val['operator'];
					} else {
						$sql .= " AND";
					}
				}

				if (strstr($val['value'], '###:')) {
					$val['value'] = str_replace('###:', '', $val['value']);
					$sql .= " BINARY `".self::sql_injection($val['field'])."` = ".self::sql_injection($val['value'])."";
				} else {
					$sql .= " BINARY `".self::sql_injection($val['field'])."` = '".self::sql_injection($val['value'])."'";
				}
			}
		}

		if (!empty($arr['others'])) {
			$sql .= " ".$arr['others'];
		}
		
		$query = MySQL::$mysqli->query($sql);

		if ($query) {
			return $query;
		} else {
			if (!MySQL::$mysqli->error) {
				die('<b>Строка:</b> '.__LINE__.'<br/><b>Запрос:</b> '.$sql.'<br/><b>Ошибка:</b> '.MySQL::$mysqli->error);
			}
		}
	}

	/**
	 * Метод нативного sql запроса
	 * 
	 * @param string $sql - Строка sql запроса
	 * @access public
	 * @return Возвращает sql ответ
	 */
	public function iBaseQuery($sql)
	{
		$query = MySQL::$mysqli->query($sql);
			
		if ($query) {
			return $query;
		} else {
			if (!MySQL::$mysqli->error) {
				die('<b>Строка:</b> '.__LINE__.'<br/><b>Запрос:</b> '.$sql.'<br/><b>Ошибка:</b> '.MySQL::$mysqli->error);
			}
		}
	}

	/**
	 * Метод удаления записей из таблицы
	 * 
	 * @param array $arr - Ассоциативный массив
	 * @param string $arr['table-name'] - Имя таблицы
	 * @param array $arr['where'] - Индексный массив, принимает в себя ассоциативный массив
	 * @param array $arr['where'] - Индексный массив, принимает в себя ассоциативный массив
	 * @example 'where' => [
	 * 	[ 'field_1' => {field_name}, 'value_2' => {field_value} ],
	 * 	[ 'field_2' => {field_name}, 'value_2' => {field_value} ]
	 * ]
	 * @access public
	 * @method Вызывается метод {sql_injection}
	 * @return Возвращает sql ответ
	 */
	public function iDeleteTable($arr = [])
	{
		if($arr['sql'] == true) {
			$sql = $arr['query'];
		} else {
			if (sizeof($arr['where'])) {
				$sql = "DELETE FROM `".self::sql_injection($arr['table-name'])."` WHERE";

				foreach ($arr['where'] as $key => $val) {
					$sql .= " `".self::sql_injection($val['field'])."` = '".self::sql_injection($val['value'])."'";

					if ($key > 0 && $key < (sizeof($arr['where'])-1)) {
						if (isset($val['operator']) && !empty($val['before'])) {
							$sql .= " ".$val['operator'];
						} else {
							$sql .= " AND";
						}
					}
				}
			} else {
				$sql = "DROP TABLE `".self::sql_injection($arr['table-name'])."`";
			}
		}

		$query = MySQL::$mysqli->query($sql);

		if ($query) {
			return $query;
		} else {
			if (!MySQL::$mysqli->error) {
				die('<b>Строка:</b> '.__LINE__.'<br/><b>Запрос:</b> '.$sql.'<br/><b>Ошибка:</b> '.MySQL::$mysqli->error);
			}
		}
	}

	/**
	 * Метод фильтрации sql инъекций
	 * 
	 * @param string $sql - Строка sql запроса
	 * @access public
	 * @method Вызывается метод {MySQL::$mysqli->query}
	 * @return Возвращает строку
	 */
	public static function sql_injection($str)
	{
		if (get_magic_quotes_gpc() == 1) {
			$str = stripslashes($str);
		}
		
		return MySQL::$mysqli->real_escape_string($str);
	}
}