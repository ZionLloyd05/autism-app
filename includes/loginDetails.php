<?php 

require_once ('database.php');
require_once ('db_object.php');
require_once 'session.php';

class LoginDetails extends db_object
{
    protected static $db_table = "loginDetailstbl";
    protected static $db_table_fields = array("user_id","lastLoginActivity");

    public $id;
    public $user_id;
    public $lastLoginActivity;

    public static function IsUserSaved($user_id){
        $get_user = LoginDetails::find_by_id2($user_id);
        
        return $get_user;
    }

    public static function set_type($user_id, $isType){
        global $database;
        $query = "UPDATE loginDetailstbl SET isType = '$isType' WHERE user_id = '$user_id'";
        $database->query($query);
    }

    //fetching user typing status for notification
    public static function fetch_type_status($userid){
        global $database;
        $query = "SELECT isType FROM loginDetailstbl WHERE user_id = '$userid'";
        $result = $database->query($query);
        $output = '';
        while($row = $database->fetch_array($result)){
            if($row['isType'] == 'yes'){
                $output = ' - <small><em><span style="font-size:12px;"
                    class="text-muted">Typing.....</span></em></small>
                ';
            }
        }

        return $output;
    }
    
} 

// $lg = new LoginDetails();
// // echo ($lg->IsUserSaved("we_232"));
// if($lg->IsUserSaved("we_2342")){
//     echo "true";
// }else{
//     echo "false";
// }

?>