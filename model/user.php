<?php 
require_once("model.php");

class User extends Model {

	protected $user_id;
	public $user_name;
	public $password;
	public $email;
	public $phone;
	public $profile_image;
	public $first_name;
	public $last_name;

	public static function getTableName() {
		return "user";
	}

	public function getId(){
		return $this->user_id;
	}

	public static function login($data) {

			session_start();

		$db = DB::getInstance();
		$statement = $db->prepare("SELECT `user_id` from `user` where `user_name` = :username and `password` = :password");
		$statement->execute(array(':username' => $data["username"], ':password' => $data["password"]));
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		if(isset($result["user_id"])){
			$_SESSION["current_user"] = $result["user_id"];
			return true;
		} else {
			return false;
		}
	}

	public static function logout()
	{
		unset($_SESSION["current_user"]);
	}
} 


?>