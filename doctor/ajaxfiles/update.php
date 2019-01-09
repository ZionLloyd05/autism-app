<?php
require_once "../../includes/doctor.php";
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

//update doctor
if(isset($_POST['fname'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pwd = $_POST['pwd'];
    $upwd = $_POST['upwd'];
    $user_id = $_POST['user_id'];
    $doc_id = $_POST['doc_id'];

    $doctor = new Doctor();
    $doctor->firstname = $fname;
    $doctor->lastname = $lname;
    $doctor->email = $email;
    $doctor->phone = $phone;
    $doctor->id = $user_id;
    $doctor->doctorId = $doc_id;
    if($pwd == ""){
        $doctor->password = $upwd;
    }else{
        $hashedPass = $database->cryptPass($pwd);
        $doctor->password = $hashedPass;
    }

    if($doctor->save()){
        echo "Profile Successfully Updated";
    }
}
    
?>