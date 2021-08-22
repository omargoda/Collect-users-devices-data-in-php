<?php
	class DB {
		  private static function connect () {
			$pdo = new PDO('mysql:host=host-name;dbname=db-name;charset=utf8', 'username', 'password');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		  }
		  public static function query ($query, $params = array()) {
			$statement = self::connect()->prepare($query);
			$statement->execute($params);
			if (explode(' ', $query)[0] == 'SELECT') {
			$data = $statement->fetchAll();
			return $data;
			}
		  }
	}
	echo (int)DB::query('SELECT COUNT(*) FROM screens', array())[0]['COUNT(*)'] - 2;
?>
