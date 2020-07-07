<?php
namespace HandlerName;

use MySQLName\MySQL;

class HandlerDB
{
	//Соединяемся с базой
	function __construct()
	{
		MySQL::iConnect();
		$this->Init();
	}

	//Подгружаем и готовим работу
	public function Init()
	{
		//$this->createDefaultTables();
		//$this->InsertDefaultValues();
	}

	//Создаем стандартные таблицы
	private function createDefaultTables()
	{
		//Создание таблицы пользователей
		$q = MySQL::$mysqli->query("CREATE TABLE IF NOT EXISTS `users` 
									(`id` INT(250) PRIMARY KEY AUTO_INCREMENT,
									 `login` VARCHAR(255),
									 `password` TEXT,
									 `email` VARCHAR(255),
									 `service_id` INT(250),
									 `service_name` VARCHAR(255),
									 `group` INT DEFAULT 0 NOT NULL,
									 `active` INT(1) DEFAULT 0 NOT NULL,
									 `name` VARCHAR(255),
									 `surname` VARCHAR(255),
									 `patronymic` VARCHAR(255),
									 `country` VARCHAR(255),
									 `city` VARCHAR(255),
									 `sessions` MEDIUMTEXT,
									 `last_visit` DATETIME,
									 `dateCreate` DATETIME,
									 `dateEdit` DATETIME,
									 `basket` INT DEFAULT 0 NOT NULL,
									 `basketAuthor` INT(250),
									 `basketDate` DATETIME
									);");

		if (!$q) print_r('Таблица "users" не создана.<br>');

		/* ************ */
		$q = MySQL::$mysqli->query("CREATE TABLE IF NOT EXISTS `logsAuth` 
									(`id` INT(250) PRIMARY KEY AUTO_INCREMENT,
									 `title` VARCHAR(255),
									 `dateCreate` DATETIME,
									 `dateEdit` DATETIME,
									 `authorID` INT(250),
									 FOREIGN KEY (`authorID`) REFERENCES `users` (`id`)
									);");

		if (!$q) print_r('Таблица "countries" не создана.<br>');

		/* ************ */
		$q = MySQL::$mysqli->query("CREATE TABLE IF NOT EXISTS `countries` 
									(`id` INT(250) PRIMARY KEY AUTO_INCREMENT,
									 `title` VARCHAR(255),
									 `dateCreate` DATETIME,
									 `dateEdit` DATETIME,
									 `authorID` INT(250),
									 `basket` INT DEFAULT 0 NOT NULL,
									 `basketAuthorID` INT(250),
									 `basketDate` DATETIME,
									 FOREIGN KEY (`authorID`) REFERENCES `users` (`id`),
									 FOREIGN KEY (`basketAuthorID`) REFERENCES `users` (`id`)
									);");

		if (!$q) print_r('Таблица "countries" не создана.<br>');

		/* ************ */
		$q = MySQL::$mysqli->query("CREATE TABLE IF NOT EXISTS `cities` 
									(`id` INT(250) PRIMARY KEY AUTO_INCREMENT,
									 `title` VARCHAR(255),
									 `countryID` INT(250),
									 `dateCreate` DATETIME,
									 `dateEdit` DATETIME,
									 `authorID` INT(250),
									 `basket` INT DEFAULT 0 NOT NULL,
									 `basketAuthorID` INT(250),
									 `basketDate` DATETIME,
									 FOREIGN KEY (`countryID`) REFERENCES `countries` (`id`),
									 FOREIGN KEY (`authorID`) REFERENCES `users` (`id`),
									 FOREIGN KEY (`basketAuthorID`) REFERENCES `users` (`id`)
									);");
	}

	//Создаем стандартные таблицы
	private function InsertDefaultValues()
	{
		/*$sql = "INSERT INTO `genres` 
					(`id`, `title`, `dateCreate`)
				VALUES
					(1, 'Ужасы, мистика, триллеры', NOW()),
					(2, 'Фентези', NOW()),
					(3, 'Фантастика', NOW()),
					(4, 'Приключения', NOW()),
					(5, 'Любовные романы', NOW()),
					(6, 'Поэзия и драматургия', NOW()),
					(7, 'Журналы и газеты', NOW()),
					(8, 'Религия', NOW()),
					(9, 'Эзотерика', NOW()),
					(10, 'Спорт и Фитнес', NOW()),
					(11, 'Справочники и энциклопедии', NOW()),
					(12, 'Старинные книги (мифы, легенды, эпос)', NOW()),
					(13, 'Фольклор и народное творчество', NOW()),
					(14, 'Экономика и бизнес', NOW()),
					(15, 'Юмор', NOW()),
					(16, 'Компьютерная литература', NOW()),
					(17, 'Искусство (музыка, театр, фотография, изобразительное искусство)', NOW()),
					(18, 'Документальная литература', NOW()),
					(19, 'Наука и образование', NOW()),
					(20, 'Саморазвитие', NOW()),
					(21, 'Художественная литература', NOW()),
					(22, 'Жанр неизвестен', NOW())";
		$i = MySQL::$mysqli->query($sql);
		if (!MySQL::$mysqli->error) {
			print_r('<b>Строка:</b> '.__LINE__.'<br/><b>Запрос:</b> '.$sql.'<br/><b>Ошибка:</b> '.MySQL::$mysqli->error);
		}*/
	}

	//Метод добавления записи в БД
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
					$sql .= "'".$val."',";
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

	public function iGetTableData($table_name, $key, $key_field, $field, $ech = false)
	{
		$sel = $this->iSelectTable([
			'table-name' => $table_name,
			'where' => [
				[
					'field' => $key_field,
					'value' => $key
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

	//Метод получения записей из БД
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

	//Метод обновления записи в БД
	public function iUpdateTable($table_name, $arr = [], $arr2 = [])
	{
		$fields = null;
		$sql = "UPDATE `".self::sql_injection($table_name)."` SET ";

		foreach ($arr as $key => $val) {
			if (strstr($val, '###:')) {
				$val = str_replace('###:', '', $val);
				$fields .= "`".self::sql_injection($key)."` = ".self::sql_injection($val).",";
			} else {
				$fields .= "`".self::sql_injection($key)."` = '".self::sql_injection($val)."',";
			}
		}

		$fields = substr($fields, 0, -1);
		$sql .= $fields;

		if (empty($arr2[1])) {
			$arr2[1] = 'AND';
		}

		$sql .= " WHERE ";

		foreach ($arr2[0] as $key => $val) {
			$sql .= "`".self::sql_injection($key)."` = '".self::sql_injection($val)."' ".$arr2[1];
		}

		$sql = substr($sql, 0, -3);
		$query = MySQL::$mysqli->query($sql);

		if ($query) {
			return $query;
		} else {
			if (!MySQL::$mysqli->error) {
				die('<b>Строка:</b> '.__LINE__.'<br/><b>Запрос:</b> '.$sql.'<br/><b>Ошибка:</b> '.MySQL::$mysqli->error);
			}
		}
	}

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

	//Метод удаления записей из БД
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

	public static function sql_injection($str)
	{
		if (get_magic_quotes_gpc() == 1) {
			$str = stripslashes($str);
		}
		
		return MySQL::$mysqli->real_escape_string($str);
	}
}