<?php

require_once "../includes/doctor.php";
require_once "../includes/session.php";
require_once "../includes/patient.php";
require_once "../includes/loginDetails.php";

$lgDetails = new LoginDetails();

##This is the script that verifies the admin credentials, to see if he or she exist in the DB
if(isset($_POST['password']) && (isset($_POST['email'])) ){
    $email = $database->escape_val($_POST['email']);
    $password = $database->escape_val($_POST['password']);
    $userType = $database->escape_val($_POST['usertype']);

    if($userType == "Doctor"){
        $found_user = Doctor::authenticate($email, $password);

        if($found_user){
            if($found_user != null){
                global $session;
                $session->login($found_user, "doctor");

                 // save log in activity
                 $details = $lgDetails->IsUserSaved($found_user->doctorId);

                 //check if login activity already saved
                 $lg_id = "";
                 if($details->num_rows > 0){
                     while($row = $database->fetch_array($details)){
                         $lg_id = $row['id'];
                     }
                     //update timestamp
                     $lgDetails->id = $lg_id;
                     $lgDetails->user_id = $found_user->doctorId;
                     $lgDetails->lastLoginActivity = date('Y-m-d H:i:s');
                     $lgDetails->save();
                     
                 }else{
                     
                     //save new user
                     $lgDetails->user_id = $found_user->doctorId;
                     $lgDetails->lastLoginActivity = date('Y-m-d H:i:s');
                     $lgDetails->save();
                 }

                $returnBox = array(
                    "response" => "1"
                );

                echo json_encode($returnBox);
            }
        }
        else
        {
            $returnBox = array(
                "response" => "0"
            );

            echo json_encode($returnBox);

        }
    }

    if($userType == "Patient"){
        $found_user = Patient::authenticate($email, $password);

        if($found_user){
            if($found_user != null){
                global $session;
                global $database;
                $session->login($found_user, "patient");

                // save log in activity
                $details = $lgDetails->IsUserSaved($found_user->patient_id);

                //check if login activity already saved
                $lg_id = "";
                if($details->num_rows > 0){
                    while($row = $database->fetch_array($details)){
                        $lg_id = $row['id'];
                    }
                    //update timestamp
                    $lgDetails->id = $lg_id;
                    $lgDetails->user_id = $found_user->patient_id;
                    $lgDetails->lastLoginActivity = date('Y-m-d H:i:s');
                    $lgDetails->save();
                    
                }else{
                    
                    //save new user
                    $lgDetails->user_id = $found_user->patient_id;
                    $lgDetails->lastLoginActivity = date('Y-m-d H:i:s');
                    $lgDetails->save();
                }
                // print_r($details);
                $returnBox = array(
                    "response" => "2"
                );

                echo json_encode($returnBox);
            }
        }
        else
        {
            $returnBox = array(
                "response" => "3"
            );

            echo json_encode($returnBox);

        }
    }

}
?>