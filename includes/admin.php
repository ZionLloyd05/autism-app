<?php 

require_once ('database.php');
require_once ('db_object.php');
require_once 'session.php';

class Admin extends db_object
{
    protected static $db_table = "admintbl";
    protected static $db_table_fields = array("admin_id","email","fullname","dept","password","telephone");

    public $id;
    public $admin_id;
    public $email;
    public $fullname;
    public $dept;
    public $password;
    public $telephone;

    private function has_attribute($attribute)
    {
            $object_vars = get_object_vars($this);

            return array_key_exists($attribute, $object_vars);
    }


    private static function instantiate($record)
    {
            $object = new self;

            //more dynamic and short
            foreach($record as $attribute=>$value){
                if ($object->has_attribute($attribute)) {
                    $object->$attribute = $value;
                }
            }
            return $object;
    }



    public static function find_by_string($column_name = "", $string = "")
    {
        global $database;
        $the_result_array = $database->query("SELECT * FROM " . static::$db_table . " WHERE $column_name = '$string' LIMIT 1");
        return $the_result_array;
    }



    public static function find_by_sql($sql = "")
    {
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

    public static function authenticate($username= "", $password= "")
	{
		global $database;
		$hashedPassword = '';
		$username = $database->escape_val($username);
		$password = $database->escape_val($password);

		$sql = "SELECT * FROM " . static::$db_table."
		WHERE email = '{$username}'
		LIMIT 1";

        $result = $database->query($sql);
        while($row = $database->fetch_array($result)){
           $hashedPassword = $row['password'];
        }
		
		if($hashedPassword != ''){
			if(crypt($password, $hashedPassword) == $hashedPassword){
				$result_array = self::find_by_sql($sql);
				return !empty($result_array) ? array_shift($result_array) : false;
			}else{
				return false;
			}
		}
        

    }

      //checking if email exist
      public static function check_if_email_exist($email){
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE email = '$email' LIMIT 1";
        $query = $database->query($sql);
        $result = $database->fetch_array($query);
        return $result[0];
    }
    
} 

// echo $database->cryptPass("zionloyd");
?>