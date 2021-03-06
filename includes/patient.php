<?php 

require_once 'db_object.php';
require_once 'database.php';

class Patient extends db_object
{
    protected static $db_table = "patienttbl";
    protected static $db_table_fields = array("patient_id","pfirstname","plastname","dob","bloodgroup","genotype",
                                               "gfirstname","glastname","email","phone","password");

    public $id;
    public $patient_id;
    public $pfirstname;
    public $plastname;
    public $dob;
    public $bloodgroup;
    public $genotype;
    public $gfirstname;
    public $glastname;
    public $password;
    public $email;
    public $phone;

    
    public static function update_password($password,$email){
        global $database;
        $sql = "UPDATE " . static::$db_table . " SET password = '$password' WHERE email = '$email'";
        
        $database->query($sql);
    }

    public static function return_email($id){
        global $database;
        $sql = "SELECT * FROM  " . static::$db_table . " WHERE id = '$id'";

        $result = $database->query($sql);
        while($row = $database->fetch_array($result)){
            $email = $row['email'];
        }

        return $email;
    }

    public function randomString($length = 6) {
    	$str = "";
    	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
    	$max = count($characters) - 1;
    	for ($i = 0; $i < $length; $i++) {
    		$rand = mt_rand(0, $max);
    		$str .= $characters[$rand];
    	}
	      return $str;
    }

    public static function authenticate($email= "", $password= "")
	{
		global $database;
		$hashedPassword = '';
		$email = $database->escape_val($email);
		$password = $database->escape_val($password);
        
		$sql = "SELECT * FROM " . static::$db_table."
		WHERE email = '{$email}'
		LIMIT 1";

        
        $result = $database->query($sql);
        while($row = $database->fetch_array($result)){
            $hashedPassword = $row['password'];
        }

        if(crypt($password, $hashedPassword) == $hashedPassword){
            // echo "it matched";
            $result_array = self::find_by_sql($sql);
            // echo $result_array;
            return !empty($result_array) ? array_shift($result_array) : false;
        }else{
            // echo "it does not match";
            return false;
        }

    }
    
    public static function find_by_sql($sql = ""){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
        foreach ($object_array as $item)
            echo $item;
    }

    private static function instantiate($record){
        $object = new self;

        //more dynamic and short
        foreach($record as $attribute=>$value){
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute){
        $object_vars = get_object_vars($this);

        return array_key_exists($attribute, $object_vars);
    }

    //checking if email exist
    public static function check_if_email_exist($email){
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE email = '$email' LIMIT 1";
        $query = $database->query($sql);
        $result = $database->fetch_array($query);
        return $result[0];
    }

    public static function get_pat_info($id){
        global $database;
        $gd_info = array();
        $sql = "SELECT * FROM ".static::$db_table." WHERE patient_id = '$id' LIMIT 1";
        $result = $database->query($sql);

        while($row = $database->fetch_array($result)){
            array_unshift($gd_info, $row['pfirstname']);
            array_unshift($gd_info, $row['plastname']);
        }

        return $gd_info;
    }

    public static function get_user_type($id){
        global $database;
        $user_type = '';
        $sql = "SELECT * FROM ".static::$db_table." WHERE patient_id = '$id' LIMIT 1";
        $result = $database->query($sql);

        while($row = $database->fetch_array($result)){
            $user_type = true;
        }

        return $user_type;
    }

    public static function get_full_info($id){
        global $database;
        $gd_info = array();
        $sql = "SELECT * FROM ".static::$db_table." WHERE patient_id = '$id' LIMIT 1";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
       
        return $row;
    }
 
}

?>