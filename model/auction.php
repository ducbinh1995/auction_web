<?php 
	
	require_once("model.php");
	require_once("product.php");
	require_once("message.php");

	class Auction extends Model {

		public $auction_id;
		public $user_id;
		public $product_id;
		public $created;
		public $image;
		public $step;
		public $current_price;
		public $start_date;
 		public $end_date;
 		public $product;
		
 		public function __construct($data) {
 			$product = Product::findById($data["product_id"]);
 			$data["product"] = $product;
 			foreach($data as $key => $value) {
 				$this->$key = $value;
 			}
 		}

		public static function getTableName() {
			return "auction";
		}

		public function getId() {
			return $this->auction_id;
		}

		public function bid($price)
		{
			if(!isset($_SESSION["current_user"]))
				 return ("You have to login first");

			if($price < $this->current_price + $this->step){

				return ("You have to bid higher");

			} else {
				Message::create(array("user_id" => $this->user_id, "description" => "Someone pay higher bid than you on your watching auction"));

				$this->updateById(array("current_price" => $price, "user_id" => $_SESSION["current_user"]));
				return "Success";
			}
		}
	}
 ?>