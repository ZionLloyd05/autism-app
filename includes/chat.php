<?php 

require_once ('database.php');
require_once ('db_object.php');
require_once 'session.php';
require_once 'patient.php';
require_once 'doctor.php';

class Chat extends db_object
{
    protected static $db_table = "chat_message";
    protected static $db_table_fields = array("to_user_id","from_user_id","chat_message");

    public $id;
    public $to_user_id;
    public $from_user_id;
    public $chat_message;
    public $timestamp;
    

    public static function fetch_chat_history($from_user_id, $to_user_id){
        global $database;

        $sql = "SELECT * FROM chat_message WHERE (from_user_id = '$from_user_id' AND to_user_id = '$to_user_id') OR (from_user_id = '$to_user_id' AND to_user_id= '$from_user_id') ORDER BY timestamp DESC";
        $result = $database->query($sql);
        $output = "<ul class='list-unstyled' ";
        while($row = $database->fetch_array($result)){
            $user_name = '';
            if($row['from_user_id'] == $from_user_id){
                $user_name = '<b class="text-success">You</b>';
            }else{
                $user_name = '<b class="text-danger">'.Chat::get_user_name($row['from_user_id']).'</b>';
            }
            if($row['from_user_id'] == $from_user_id){
                $output .= '
                <li style="padding-right: 1px;font-size: 13px;text-align:right;">
                    <p>'.$user_name.' - '.$row["chat_message"].'
                        <div>
                            - <small><em>
                                '.$row['timestamp'].'
                            </em></small>
                        </div>
                    </p>
                </li>
            ';
            }else{
                $output .= '
                <li style="padding-left: 1px;font-size: 13px;text-align:left;">
                    <p>'.$user_name.' - '.$row["chat_message"].'
                        <div>
                            - <small><em>
                                '.$row['timestamp'].'
                            </em></small>
                        </div>
                    </p>
                </li>
            ';
            }
            
        }
        
        $output .= '</ul>';

        $query = "UPDATE ". static::$db_table ." SET status = 0 WHERE from_user_id = '$to_user_id' AND to_user_id = '$from_user_id' AND status = 1";
        $result = $database->query($query);

        return $output;
    
    }

    public static function get_user_name($user_id){
        $doctor = new Doctor();
        $patient = new Patient();
        $IsDoctor = $doctor->get_user_type($user_id);
        $IsPatient = $patient->get_user_type($user_id);

        if($IsDoctor){
            $doc_info = $doctor->get_doc_info($user_id);
            return $doc_info[1]." ".$doc_info[0];
        }
        if($IsPatient){
            $pat_info = $patient->get_pat_info($user_id);
            return $pat_info[1]." ".$pat_info[0];
        }
    }

    public static function count_unseen_message($from_user_id, $to_user_id){
        global $database;
        $query = "SELECT * FROM ". static::$db_table." WHERE from_user_id = '$from_user_id' AND to_user_id = '$to_user_id' AND status = '1'";
        $result = $database->query($query);
        $count = $result->num_rows;
        $output = '';
        if($count > 0){
            $output = '<span style="color:white;font-size:10px;margin-right:20px;" class="label label-rouded label-primary">'.$count.'</span>';
        }
        return $output;
    }

    public static function count_all_unseen($from_user_id){
        global $database;
        $query = "SELECT * FROM ". static::$db_table." WHERE to_user_id = '$from_user_id' AND status = '1'";
        $result = $database->query($query);
        $count = $result->num_rows;
        return $count;
        
    }

    public static function count_all_unseen_chat($to_user_id){
        global $database;
        $query = "SELECT * FROM ". static::$db_table." WHERE to_user_id = '$to_user_id' AND status = '1'";
        $result = $database->query($query);        

        return $result;
    }

    public static function mark_as_seen($from_user_id, $to_user_id){
        global $database;
        $query = "UPDATE ". static::$db_table ." SET status = 0 WHERE from_user_id = '$to_user_id' AND to_user_id = '$from_user_id' AND status = 1";
        $result = $database->query($query);
        // return $result->num_rows;
    }
    
} 

    // echo (Chat::count_unseen_message('Hen_672967','Att_27592'));
?>