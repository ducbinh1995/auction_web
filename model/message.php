<?php 
	
	require_once("model.php");

	class Message extends Model {
		
		protected $message_id;
		public $user_id;
		public $created;
		public $description;

		public static function getTableName() {
			return "message";
		}

		public function getId() {
			return $this->message_id;
		}

	}

 ?>