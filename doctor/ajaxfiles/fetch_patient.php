<?php 
     require_once "../../includes/patient.php";
     require_once "../../includes/chat.php";
     require_once "../../includes/loginDetails.php";

    $get_patients = Patient::find_all();
    $pat_id = "";
    while($row = $database->fetch_array($get_patients)){
        $pat_id = $row['patient_id'];
        echo '<div data-tousername="'.$row['pfirstname'].' '.$row['plastname'].'" data-touserid="'.$row['patient_id'].'" class="start_chat media chatBody no-border">';
            echo '<div class="media-left">';
                  echo '<a href="#"><img alt="..." src="images/avatar/doc.png" class="media-object"></a>';
            echo '</div>';
            echo '<div class="media-body">';
                echo '<input type="hidden" id="lastLogin">';
                    echo '<h4 class="media-heading status">'.$row['pfirstname'].' '.$row['plastname'].' ';
                
                    $current_timestamp = strtotime(date('Y-m-d H:i:s') . '-10 Seconds'); 
                    $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
                    $fetch_details = LoginDetails::find_by_id2($row['patient_id']);
                    $user_last_login = "";
                    while($row = $database->fetch_array($fetch_details)){
                        $user_last_login = $row['lastLoginActivity'];
                    }

                    if (!empty($user_last_login) && ($user_last_login > $current_timestamp)){
                        echo '<span style="color:white;" class="badge badge-success">Online</span>'.LoginDetails::fetch_type_status($pat_id);
                    }else{
                        echo '<span style="color:white;" class="badge badge-secondary">Offline</span>';
                    }
                        
                
                  echo '</h4>';
                    
                  if (!empty($user_last_login) && ($user_last_login > $current_timestamp)){
                        echo '<p style="font-size:13px;">'.$user_last_login.'</p>';
                    }else{
                        echo '<p style="font-size:13px;">Last seen: '.$user_last_login.'</p>';
                    }
                    
                    echo '<div style="font-size:35px;" class="comment-date">';
                    echo Chat::count_unseen_message($pat_id,$_POST['userid']);
                    echo '<i class="fa fa-address-book"></i> ';
            echo '</div>';
        echo '</div>';
        echo '</div>';
    }
     
?>