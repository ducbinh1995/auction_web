<?php 
	require_once("model.php");

	class Category extends Model {
		public $category_id;
		public $category_name;

		public static function getTableName(){
			return "category";
		}

		public function getId(){
			return $this->category_id;
		}
	}
 ?>