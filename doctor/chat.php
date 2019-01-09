<?php
     require_once "../includes/patient.php";
     require_once "../includes/doctor.php";
     require_once "../includes/session.php";  
     require_once "../includes/chat.php";
     require_once "../includes/symptom.php";
     require_once "../includes/appointment.php";
     require_once "../includes/loginDetails.php";

     ##Checking if the user has logged in recently
     if($session->is_signed_in()){
   
       ##Fetching doc info
       $get_doc_info = Doctor::get_doc_info($session->user_id);
   
       $doc_firstname = $get_doc_info[1];
       $doc_lastname = $get_doc_info[0];
       
       }else{
         header("Location: ../index.php");
       }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Messaging | HMS</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    
        <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        div.chatBody{
            padding-right: 2%;
            padding-left: 2%;
        }
        div.chatBody:hover {
            box-shadow: 2px 2px 2px 2px #999;
            border-radius: 5px;
            transition: box-shadow 0.5s;
            cursor: pointer;
        }
        .chat_message_area{
            position: relative;
            width: 100%;
            height:auto;
            background-color:#FFF;
            border-radius: 3px;
            border: 1px solid #CCC;
        }
        .chat_message{
            width: 100%;
            height: auto;
            min-height: 80px;
            overflow: auto;
            padding: 6px 24px 6px 12px;
            font-size: 12px;
            margin-bottom:5px;
        }
        .chat_message:focus{
            background:white;
            border: 1px solid #CCC;
        }
        .chat_message:hover{
            background:white;
            border: 1px solid #CCC;
        }
        .image_upload{
            position:absolute;
            top: 3px;
            right: 3px;
        }
        .image_upload > form > input {
            display: none;
        }
        .image_upload img {
            width: 24px;
            cursor: pointer;
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>Hi</b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span user-id="<?php echo $session->user_id; ?>" class="userInfo">, <?php echo $doc_firstname; ?></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- Messages -->
                        
                        <!-- End Messages -->
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">

                        <!-- Comment -->
                        <?php
                            $get_app_count = Appointment::count_upcoming_app($session->user_id);
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
                            <?php
                            if($get_app_count > 0){
                                echo '<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>';
                            }
                            ?>
							</a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Upcoming Appointments</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <?php
                                            if($get_app_count > 0){
                                                $get_app = Appointment::get_app($session->user_id);
                                                while($row = $database->fetch_array($get_app)){
                                                    $pat_info = Patient::get_pat_info($row['patientid']);
                                                    ?>
                                                    <a href="#">
                                                        <div class="btn btn-danger btn-circle m-r-10"><i class="fa fa-link"></i></div>
                                                        <div class="mail-contnet">
                                                            <h5><?php echo $pat_info[1]." ".$pat_info[0]; ?></h5> <span class="mail-desc"><?php if($row["note"] == ""){ echo "No Note..."; } else { echo $row["note"]; } ?></span> <span class="time"><?php echo $row['fixeddate']." ".$row['fixedtime']; ?></span>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                           <?php
                                            }else{
                                                echo "  No Upcoming Appointment...";
                                            }
                                           ?>    
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="appointment.php"> <strong>Check all appointments</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Comment -->
                        <!-- Messages -->
                        <?php
                            $get_unseen_chatCount = Chat::count_all_unseen($session->user_id);
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
                            <?php
                            if($get_unseen_chatCount > 0){
                                echo '<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>';
                            }?>
							</a>
                            <div class="dropdown-menu dropdown-menu-right animated mailbox zoomIn" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title"><?php if($get_unseen_chatCount > 0){ echo "You have ".$get_unseen_chatCount." new messages";}else{ echo "No Unseen Message..";} ?></div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <?php
                                            if($get_unseen_chatCount > 0){
                                                $get_chat = Chat::count_all_unseen_chat($session->user_id);
                                                while($row = $database->fetch_array($get_chat)){
                                                    $pat_info = Patient::get_pat_info($row['from_user_id']);
                                                    ?>
                                                    <a href="#">
                                                        <div class="user-img"> <img src="images/avatar/doc.png" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                        <div class="mail-contnet">
                                                            <h5><?php echo $pat_info[1]." ".$pat_info[0]; ?></h5> <span class="mail-desc"><?php echo $row['chat_message'] ?></span> <span class="time"><?php echo $row['timestamp'] ?></span>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                           <?php
                                            }else{
                                                echo "  No Unseen Message.";
                                            }
                                           ?> 
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="chat.php"> <strong>See all Messages</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Messages -->
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/avatar/doc.png" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="settings.php"><i class="ti-settings"></i> Setting</a></li>
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li> <a href="index.php" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard </span></a>
                                
                            </li>
                            <li class="nav-label">Records</li>
                            <li> <a  href="precord.php" aria-expanded="false"><i class="fa fa-address-card"></i><span class="hide-menu">Patient</span></a></li>
                            <li> <a  href="symptom.php" aria-expanded="false"><i class="fa fa-ambulance"></i><span class="hide-menu">Symptom</span></a></li>
                            <li> <a  href="appointment.php" aria-expanded="false"><i class="fa fa-calendar"></i><span class="hide-menu">Appointment</span></a></li>

                            <li class="nav-label">Messaging</li>
                            <li> <a href="chat.php" aria-expanded="false"><i class="ti-email"></i><span class="hide-menu">Chat</span></a></li>
                            <li class="nav-label">Others</li>
                            <li> <a href="settings.php" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Settings</span></a></li>
                            <li> <a href="logout.php" aria-expanded="false"><i class="fa fa-power-off"></i><span class="hide-menu">Log Out</span></a></li>
                        </ul>
                    </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Messaging</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Messaging</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                    <div class="card">
                            <div class="card-body p-b-0">
                                    <!-- <h4 class="card-title">Customtab Tab</h4> -->
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Patients</span></a> </li>
                                        <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Doctors</span></a> </li> -->
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                                    </ul>
                                <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="home2" role="tabpanel">
                                     <div class="p-20">
                                     <div class="recent-comment userChat">
                                                                                  
                                    </div>
                                    <div id="user_modal_details"></div>
                                </div>
                                </div>
                                    <div class="tab-pane  p-20" id="messages2" role="tabpanel">
                                    <div class="row">                                    
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="card-two">
                                                        <header>
                                                            <div class="avatar">
                                                                <img src="images/avatar/doc.png" alt="Allison Walker">
                                                            </div>
                                                        </header>

                                                        <h3>
                                                            <?php
                                                                $doc_info = Doctor::get_doc_info($session->user_id);
                                                                echo "Dr. ".$doc_info[1]." ".$doc_info[0];
                                                            ?>
                                                        </h3>
                                                        <div class="contacts">
                                                            <a href=""><i class="fa fa-whatsapp"></i></a>
                                                            <a href=""><i class="fa fa-envelope"></i></a>
                                                            <a href=""><i class="fa fa-phone"></i></a>
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                    
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Developed By <a href="https://">ZIonLloyd</a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <!-- <script src="js/lib/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap tether Core JavaScript -->
    <!-- <script src="js/lib/bootstrap/js/popper.min.js"></script> -->
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <script>
        $(document).ready(function(){
            var userid = $(".userInfo").attr("user-id");
            
            fetch_users();

            setInterval(function(){
                update_last_activity();
                fetch_users();
                update_chat_history_data();
            }, 5000);
        
            function fetch_users(){

                $.ajax({
                    url: "ajaxfiles/fetch_patient.php",
                    method:"POST",
                    data:{
                        'userid':userid
                    },
                    success: function(data){
                        $('.userChat').html(data);
                    }
                })
            }

            function update_last_activity(){

                $.ajax({
                    url: "ajaxfiles/update.php",
                    method: "POST",
                    data:{'userid': userid},
                    success: function(data){
                        // alert(data);
                    }
                })
            }
            
            function make_chat_dialog_box(to_user_id, to_user_name){
                
                var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="'+to_user_name+'">';

                modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
                modal_content += fetch_user_chat_history(to_user_id);
                modal_content += '</div>';
                modal_content += '<div class="form-group">';
                // modal_content += '<textarea style="font-size: 12px;border-radius:5px;" name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
                modal_content += '<div class="chat_message_area">';
                modal_content += '<div contenteditable name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></div>';
                modal_content += '<div class="image_upload"><form id="uploadImage" to-user='+to_user_id+' method="POST" action="ajaxfiles/upload.php"><label for="uploadFile"><img src="images/upload2.ico"/></label><input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png" /></form></div>';
                modal_content += '</div>';
                modal_content += '</div><div class="form-group" align="right">';
                modal_content += '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';

                $('#user_modal_details').html(modal_content);
            }
            var to_user_id = "";
            var to_user_name = "";

            $(document).on("click", ".start_chat", function(){
                to_user_id = $(this).data('touserid');
                 to_user_name = $(this).data('tousername');
                 var from_user_id = userid;
                 var task = "mark_seen";
                make_chat_dialog_box(to_user_id, to_user_name);

                $("#user_dialog_"+to_user_id).dialog({
                    autoOpen:false,
                    width:400
                });
                $("#user_dialog_"+to_user_id).dialog('open');

                $.ajax({
                    url: "ajaxfiles/update.php",
                    method: "POST",
                    data: {
                        'from_user_id':from_user_id,
                        'to_user_id':to_user_id,
                        'task':task
                    },
                    success:function(data){
                        
                    }
                })
            });

            $(document).on("click", ".ui-dialog-titlebar-close", function(){
                $('.user_dialog').dialog('destroy').remove();
            })

            $(document).on("click", ".send_chat", function(){
                var to_user_id = $(this).attr('id');
                var from_user_id = userid;
                var chat_message = $('#chat_message_'+to_user_id).html();
                $.ajax({
                    url: "ajaxfiles/saveChat.php",
                    method:"POST",
                    data:{
                        'to_user_id':to_user_id,
                        'from_user_id':from_user_id,
                        'chat_message':chat_message
                    },
                    success:function(data){
                        $('#chat_message_'+to_user_id).html('');
                        $('#chat_history_'+to_user_id).html(data);
                    }
                })
            })


            function fetch_user_chat_history(to_user_id){

                $.ajax({
                    url: "ajaxfiles/fetch_chat.php",
                    method: "POST",
                    data: {
                        'to_user_id':to_user_id,
                        'from_user_id':userid
                    },
                    success: function(data){
                        $('#chat_history_'+to_user_id).html(data);
                    }
                })
            }

            function update_chat_history_data(){
                $('.chat_history').each(function(){
                    var to_user_id = $(this).data('touserid');
                    fetch_user_chat_history(to_user_id);
                })
            }

            
            $(document).on('focus', '.chat_message', function(){
                var isType = 'yes';

                $.ajax({
                    url:"ajaxfiles/update.php",
                    method: "POST",
                    data:{
                        'userid':userid,
                        'isType':isType
                    },
                    success:function(data){

                    }
                })
            })
            
            $(document).on('blur', '.chat_message', function(){
                var isType = 'no';

                $.ajax({
                    url:"ajaxfiles/update.php",
                    method: "POST",
                    data:{
                        'userid':userid,
                        'isType':isType
                    },
                    success:function(data){
                        
                    }
                })
            })
            
            var to_user_id;
            $(document).on("change", "#uploadFile", function(){
                // alert("hey");
                to_user_id = $("#uploadImage").attr("to-user");
                $("#uploadImage").ajaxSubmit({
                    target: "#chat_message_"+to_user_id,
                    resetForm: true
                })
            })
        })
    </script>
</body>

</html>