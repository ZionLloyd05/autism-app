<?php

require_once 'init.php';
require_once 'database.php';


class Db_object extends Database
{

    public $errors = array();
    public $upload_errors_array = array(


        UPLOAD_ERR_OK => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."


    );
    

    public function set_file($file)
    {

        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here";
            return false;

        } elseif ($file['error'] != 0) {

            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;

        } else {


            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];


        }


    }

    public static function find_all_data()
    {
        global $database;
        $result_set = self::find_by_query("SELECT * FROM " . static::$db_table);
        return $result_set;
    }

    public static function find_by_id3($id)
    {
        global $database;
        $the_result_array = $database->query("SELECT * FROM " . static::$db_table . " WHERE id = '$id'");
        return $the_result_array;

    }

    public static function find_by_id2($id)
    {
        global $database;
        $the_result_array = $database->query("SELECT * FROM " . static::$db_table . " WHERE user_id = '$id'");
        return $the_result_array;

    }

    public static function find_all()
    {
        global $database;
        $result_set = $database->query("SELECT * FROM " . static::$db_table);
        return $result_set;
    }

    public static function find_by_query($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();
        while ($row = $database->fetch_array($result_set)) {

            $the_object_array[] = static::instantation($row);

        }

        return $the_object_array;

    }


    public static function find_by_id($id)
    {
        global $database;
        $the_result_array = self::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;


    }

    //for string id's..
    public static function find_by_string_id($column_name = "", $id = "")
    {
        global $database;
        $the_result_array = self::find_by_query("SELECT * FROM " . static::$db_table . " WHERE $column_name = '$id' LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;


    }

    public static function find_by_string($column_name = "", $string = "")
    {
        global $database;
        $the_result_array = $database->query("SELECT * FROM " . static::$db_table . " WHERE $column_name = '$string' LIMIT 1");
        return $the_result_array;
    }

    public static function instantation($the_record)
    {

        $calling_class = get_called_class();


        $the_object = new $calling_class;


        foreach ($the_record as $the_attribute => $value) {

            if ($the_object->has_the_attribute($the_attribute)) {

                $the_object->$the_attribute = $value;


            }


        }

        return $the_object;
    }


    private function has_the_attribute($the_attribute)
    {

        // $object_properties = get_object_vars($this);

        // return array_key_exists($the_attribute, $object_properties);

        return property_exists($this, $the_attribute);


    }


    protected function properties()
    {


        $properties = array();

        foreach (static::$db_table_fields as $db_field) {

            if (property_exists($this, $db_field)) {

               $properties[$db_field] = $this->$db_field;

            }

        }

        return $properties;

    }


    protected function clean_properties()
    {
        global $database;


        $clean_properties = array();


        foreach ($this->properties() as $key => $value) {

            $clean_properties[$key] = $database->escape_string($value);


        }

        return $clean_properties;


    }

    public static function delete_item($id)
    {
        global $database;

        $sql = "DELETE FROM " . static::$db_table . " WHERE id = '$id'";
        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

   
    public function save()
    {

        return isset($this->id) ? $this->update() : $this->create();

    }


    private function create()
    {
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";


        if ($database->query($sql)) {

            $this->id = $database->the_insert_id();

            return true;

        } else {

            return false;


        }


    } // Create Method


    private function update()
    {
        global $database;


        $properties = $this->clean_properties();

        $properties_pairs = array();

        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE  " . static::$db_table . "  SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;


    } // end of the update method


    public function delete()
    {
        global $database;


        $sql = "DELETE FROM  " . static::$db_table;
        $sql .= "WHERE id=" . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;


    }

    public static function find_with_limit($Limit)
    {
        global $database;

        $result_set = $database->query("SELECT * FROM " . static::$db_table . " ORDER BY date DESC LIMIT $Limit ");

        return $result_set;
    }


    public static function count_all()
    {

        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);


    }


    public function delete_photo()
    {


        if ($this->delete()) {

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->picture_path();

            return unlink($target_path) ? true : false;


        } else {

            return false;


        }
    }

    public static function delete_all_by_string_id($column_name = "", $id="")
    {
        global $database;
        $the_result_array = $database->query("DELETE FROM " . static::$db_table . " WHERE $column_name = '$id' LIMIT 4");

    }

    public static function spawn_debtor()
    {
        global $database;
        $the_result_array = $database->query("SELECT * FROM " . static::$db_table . " WHERE amount_owned > 0");
        return $the_result_array;
    }

    public static function addComma($money = "", $sign){
        $money = $money;
        $len = strlen($money);

        // reversing the money so as to appropriately add comma
        $moneyReverse = strrev($money);
        $newMoney = "";

        // insert comma into new string
        for($x=0; $x<$len; $x++){
             $newMoney .= $moneyReverse[$x];

             if($x == 2 || $x == 5 || $x == 8){
                $newMoney .= ",";
             }
        }

        // re-reversing the string to get the money value
        $currentMoney = strrev($newMoney);

        // replacing the first comma [e.g ,250,000] with an empty string cos it does not make sense!
        for ($i=0; $i < $len; $i++) {
            if($currentMoney[$i] == "," && $i == 0)
                $currentMoney[$i] = "";
        }

        return $sign."".$currentMoney;
    }

}

?>