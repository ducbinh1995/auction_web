<?php 
	class Follow extends Model {
		private $user_id;
		private $auction_id;
		private $follow_id;

		public static function getTableName() {
			return "follow";
		}

		public function getId(){
			return $this->follow_id;
		}
	}
 ?>