<?php
	
	require_once('../connection.php');	

	abstract class Model {

		public function __construct($data){
			foreach($data as $key => $value) {
				$this->$key = $value;
			}
		} 

		abstract public static function getTableName();
		abstract public function getId();

		public static function create($data)
		{
			// Data la array. VD: array("username" => "hai", "password" => "123")

			$table_key = "";
			$prepare_key = "";
			$bind_array = array();
			$table_name = static::getTableName();

			foreach($data as $data_key => $data_value){
				$table_key = $table_key . ", `" . $data_key . "`";
				$prepare_key = $prepare_key . ", :" . $data_key;
				$bind_array[$data_key] = $data_value;
			}

			//Sau khi chay ham tren:
			//		$table_key = ", `username`, `password`"
			//		$prepare_key = ", :username, :password"
			//		$bind_array = array("username" => "hai", "password" => "123")

			$table_key = substr($table_key, 1); //Bo phan tu dau cua $table_key 
			$prepare_key = substr($prepare_key, 1); //Bo phan tu dau cua $prepare_key

			try{
				$db = DB::getInstance();
				$statement = $db->prepare("INSERT INTO " . "`" . $table_name . "`" . " ( " . $table_key . ") VALUES " . "( " . $prepare_key . ")");

				$statement->execute($bind_array);
			} catch (PDOException $e){
				die($e->getMessage());
			}
			

			//return static::$tableName . 'created';
			
			/*$str = ("INSERT INTO " . "`" . self::$tableName . "`" . " ( " . $table_key . ") VALUES " . "( " . $prepare_key . ")");;*/
			return $bind_array;
		}

		public static function findById ($id){

			$table_name = static::getTableName();

			$db = DB::getInstance();
			$statement = $db->prepare("SELECT * FROM `" . $table_name . "` WHERE `" . $table_name . "_id` = :id");
			$statement->execute(array(":id" => $id));
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			return new $table_name($result);
		}

		public static function find($filter) {

			$list = array();
			$table_name = static::getTableName();

			$db = DB::getInstance();
			$statement = $db->prepare("SELECT * FROM `" . $table_name . "`");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $re){
				array_push($list, new $table_name($re));
			}
			if($filter == null){
				return $list;
			}
			$result = array_filter($list, $filter);
			return array_values($result);

		}

		public function updateById($data) {

			$table_name = static::getTableName();
			$setStr = "";
			$bind_array = array();

			foreach($data as $key => $values){
				$setStr = $setStr . " `" . $key . "` = " . ":" . $key . ",";
				$bind_array[$key] = $values;
			}

			$setStr = substr($setStr, 0, -1);

			$db = DB::getInstance();
			$statement = $db->prepare("UPDATE `" . $table_name . "` SET " . $setStr . " WHERE " . $table_name . "_id = " . $this->getId() );
			$statement->execute($bind_array);

		}
	}

?>