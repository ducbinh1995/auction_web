<?php 

require_once("model.php");

class Product extends Model {

	public $product_id;
	public $product_name;
	public $description;
	public $category_id;
	public $image;
	public $owner_id;
	public $status;

	public static function getTableName() {
		return "product";
	}

	public function getId() {
		return $this->product_id;
	}

	public function delete_product(){
		$this->updateById(array( $status => "deactive" ));
	}
}

?>