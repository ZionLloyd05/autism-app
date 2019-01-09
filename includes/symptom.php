<?php 

require_once ('database.php');
require_once ('db_object.php');
require_once 'session.php';

class Symptom extends db_object
{
    protected static $db_table = "symptomtbl";
    protected static $db_table_fields = array("name","doctorid");

    public $id;
    public $name;
    public $doctorid;
    
    public static function getStatus($id){
        global $database;
        $status = '';
        $sql = "SELECT * FROM ".static::$db_table." WHERE id = '$id' LIMIT 1";
        $result = $database->query($sql);

        while($row = $database->fetch_array($result)){
            $status = $row['status'];
        }

        return $status;
    }

    public static function find_valid_symptoms()
    {
        global $database;
        $result_set = $database->query("SELECT * FROM " . static::$db_table." WHERE status = 1");
        return $result_set;
    }

    public static function toggleStatus($id){
        
        global $database;
        $status = Symptom::getStatus($id);

        if($status == 1){
            $sql = "UPDATE " . static::$db_table . " SET status = 0 WHERE id = '$id'";
            $result = $database->query($sql);
        }else if($status == 0){
            $sql = "UPDATE " . static::$db_table . " SET status = 1 WHERE id = '$id'";
            $result = $database->query($sql);
        }

    }
} 

// $sym = new Symptom();
// echo $sym->toggleStatus(1);

// $container = array("12","23","34","12","23","34","12","23");

// $counter = 0;
// $x= 0;

// foreach ($container as $variable) {
//     if($counter % 3 == 0){
//         if($counter != 0){
//             echo '</div>';
//         }
//         echo '<div style="padding-bottom:5px;" class="d-flex justify-content-between">';
//     }
//     echo '<button type="button" class="btn btn-secondary">'.$variable.'</button>';
//     $counter++;
// }

?>