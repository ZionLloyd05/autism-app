<?php

define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("CHARSET","utf8mb4");
define("DB_NAME","hmsDB");


class Database
{

    public  $connection;




    function __construct()
    {
        $this->open_db_connection();
    }



    public function open_db_connection()
    {
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

        if($this->connection->connect_errno)
        {
            die("Database Connection Failed". $this->connection->connect_error);
        }
        
    }


    public function Close_Connection()
    {
        mysqli_close($this->connection);
    }

    public  function query($sql)
    {
        $result = mysqli_query($this->connection,$sql)  ;

        $this->confirm_query($result);

        return $result;
        $this->Close_Connection();

    }


    public function escape_val($value) {
    	if(function_exists('mysqli_real_escape_string')){
    		global $database;
    		$value = mysqli_real_escape_string($this->connection, trim($value));
    		$value = strip_tags($value);
    	}else{
    		$value = mysql_escape_string(trim($value));
    		$value = strip_tags($value);
    	}
    	return $value;
    }

	private function confirm_query($result){


		if(!$result) {
			die("Query Failed" . $this->connection->error);

		}

	}

	public function escape_string($string) {


	 $escaped_string = $this->connection->real_escape_string($string);

	 return $escaped_string;


    }
    

    public function the_insert_id()
    {
        return $this->connection->insert_id;
    }

    public function fetch_array($result_set)
    {
        return mysqli_fetch_array($result_set);
    }

    public function cryptPass($input, $rounds = 9){
        $salt = "";
        $saltChars = array_merge(range('A','Z'), range('a', 'z'), range(0,9));
        for ($i=0; $i < 22; $i++) { 
            $salt .= $saltChars[array_rand($saltChars)];
        }
        return crypt($input, sprintf('$2y$%02d$', $rounds) . $salt);
      } 

}

$database = new Database();
?>

