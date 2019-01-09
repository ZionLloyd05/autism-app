<?php 


class Session {


	private $signed_in = false;
	public  $user_id;
	public $count;
	public $message;




	function __construct() {
	session_start();
	$this->visitor_count();
	$this->check_the_login();
	$this->check_message();
    }

		public function message($msg=""){

		if(!empty($msg)) {

			$_SESSION['message'] = $msg;



		} else {

			return $this->message;
		}


	   }

	    public static function find_by_string($column_name = "", $string = "")
    {
        global $database;
        $the_result_array = $database->query("SELECT * FROM " . static::$db_table . " WHERE $column_name = '$string' LIMIT 1");
        return $the_result_array;
    }

		private function check_message(){

	 	if(isset($_SESSION['message'])) {

	 	$this->message = $_SESSION['message'];
	 	unset($_SESSION['message']);

	 	} else {

	 		$this->message = "";
	 	}


	 }

	public function visitor_count() {

		if(isset($_SESSION['count'])) {

			return $this->count = $_SESSION['count']++;

		} else {

			return $_SESSION['count'] = 1;


		}



	}


	public function is_signed_in() {

		return $this->signed_in;
	}


	public function login($user,$type) {

	if($user && $type == "doctor") {

		$this->user_id = $_SESSION['user_id'] = $user->doctorId;
		$this->signed_in = true;
	}
	else if($user && $type == "patient") {

		$this->user_id = $_SESSION['user_id'] = $user->patient_id;
		$this->signed_in = true;
	}

	}

	public function logout() {

	session_destroy();
	unset($_SESSION['user_id']);
	unset($this->user_id);
	$this->signed_in = false;


	}



 	private function check_the_login() {

 	if(isset($_SESSION['user_id'])) {

 	$this->user_id = $_SESSION['user_id'];
 	$this->signed_in = true;

 	} else {

 		unset($this->user_id);
 		$this->signed_in = false;

 	}


 }

}
$session = new Session();
 ?>