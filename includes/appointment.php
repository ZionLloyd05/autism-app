<?php 

require_once ('database.php');
require_once ('db_object.php');
require_once 'session.php';

class Appointment extends db_object
{
    protected static $db_table = "appointmenttbl";
    protected static $db_table_fields = array("doctorid","patientid","fixeddate","fixedtime","isSeen", "note");

    public $id;
    public $doctorid;
    public $patientid;
    public $fixeddate;
    public $fixedtime;
    public $createdAt;
    public $note;
    public $isSeen;    

    public static function find_all_doc_app($docid){
        global $database;
        $sql = "SELECT * FROM ". static::$db_table ." WHERE doctorid = '$docid'";
        $result = $database->query($sql);
        return $result;
    }

    public static function getStatus($id){
        global $database;
        $status = '';
        $sql = "SELECT * FROM ".static::$db_table." WHERE id = '$id' LIMIT 1";
        $result = $database->query($sql);

        while($row = $database->fetch_array($result)){
            $status = $row['isSeen'];
        }

        return $status;
    }

    public static function count_app($id)
    {
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table." WHERE doctorid = '$id'";
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);

    }

    public static function count_upcoming_app($id)
    {
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table." WHERE doctorid = '$id' AND isSeen = 1";
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);

    }

    public static function get_app($id)
    {
        global $database;

        $sql = "SELECT * FROM " . static::$db_table." WHERE doctorid = '$id' AND isSeen = 1";
        $result_set = $database->query($sql);
        
        return $result_set;

    }

    public static function toggleStatus($id){
        
        global $database;
        $status = Appointment::getStatus($id);

        if($status == 1){
            $sql = "UPDATE " . static::$db_table . " SET isSeen = 0 WHERE id = '$id'";
            $result = $database->query($sql);
        }else if($status == 0){
            $sql = "UPDATE " . static::$db_table . " SET isSeen = 1 WHERE id = '$id'";
            $result = $database->query($sql);
        }

    }

    public static function get_upcoming_app_count($patientid)
    {
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table." WHERE patientid = '$patientid' AND isSeen = 1";
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);

    }

    public static function get_upcoming_app($patientid)
    {
        global $database;

        $sql = "SELECT * FROM " . static::$db_table." WHERE patientid = '$patientid' AND isSeen = 1";
        $result_set = $database->query($sql);
        
        return $result_set;
    }
    
} 

?>