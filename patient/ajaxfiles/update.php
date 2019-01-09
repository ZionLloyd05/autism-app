<?php
require_once "../../includes/patient.php";
require_once "../../includes/chat.php";
require_once "../../includes/loginDetails.php";

$lgActivity = new LoginDetails();

//to update user timestamp "loginActivity"
if(isset($_POST['userid'])){
    $user_id = $_POST['userid'];
    $fetch_user = $lgActivity->find_by_id2($user_id);
    $activityId = "";
    global $database;
    while($row = $database->fetch_array($fetch_user)){
        $activityId = $row['id'];
    }
    // echo $activityId;
    $lgActivity->id = $activityId;
    $lgActivity->user_id = $user_id;
    $lgActivity->lastLoginActivity =  date('Y-m-d H:i:s');
    
    $lgActivity->save();
}

//to mark messages as seen
if(isset($_POST['task'])){
    $from_user_id = $_POST['from_user_id'];
    $to_user_id = $_POST['to_user_id'];

    Chat::mark_as_seen($from_user_id, $to_user_id);
}
    
//typing notification
if(isset($_POST['isType'])){
    $isType = $_POST['isType'];
    $userid = $_POST['userid'];

    $lgActivity->set_type($userid, $isType);

}

if(isset($_POST['p_id'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $blgroup = $_POST['blgroup'];
    $genotype = $_POST['genotype'];
    $gfname = $_POST['gfname'];
    $glname = $_POST['glname'];
    $pwd = $_POST['pwd'];
    $upwd = $_POST['upwd'];
    $id = $_POST['id'];
    $p_id = $_POST['p_id'];

    $patient = new Patient();
    global $database;

    $patient->id = $id;
    $patient->patient_id = $p_id;
    $patient->pfirstname = $fname;
    $patient->plastname = $lname;
    $patient->dob = $dob;
    $patient->bloodgroup = $blgroup;
    $patient->genotype = $genotype;
    $patient->gfirstname = $gfname;
    $patient->glastname = $glname;
    $patient->email = $email;
    $patient->phone = $phone;
    if($pwd == ""){
        $patient->password = $upwd;
    }else{
        $hashedPass = $database->cryptPass($pwd);
        $patient->password = $hashedPass;
    }

    if($patient->save()){
        echo "Profile updated successfully..";
    }
}
?>