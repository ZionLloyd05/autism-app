<?php

  require_once "../includes/patient.php";
  require_once "../includes/doctor.php";
  require_once "../includes/chat.php";
  require_once "../includes/symptom.php";
  require_once "../includes/appointment.php";
  require_once "../includes/session.php";
  
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
    <title>Dashboard | HMS </title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    

    <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
                        <span>, <?php echo $doc_firstname; ?></span>
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
                                                    <a href="appointment.php">
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
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" aria-labelledby="2">
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
                                                    <a href="chat.php">
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
                            <li> <a href="index.php" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard </span></a></li>
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
                    <h3 class="text-primary">Dashboard</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?php echo Patient::count_all(); ?></h2>
                                    <p class="m-b-0">Patients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-bell f-s-40 color-success"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?php echo Appointment::count_app($session->user_id); ?></h2>
                                    <p class="m-b-0">Appointment</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-comment f-s-40 color-warning"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?php echo Chat::count_all_unseen($session->user_id); ?></h2>
                                    <p class="m-b-0">Unread Message</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-ambulance f-s-40 color-primary"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?php echo Symptom::count_all(); ?></h2>
                                    <p class="m-b-0">Total Symptoms</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                        
                                            
                <div class="col-lg-6">
							<div class="card">
								<div class="card-body">
									<div class="year-calendar"></div>
								</div>
							</div>
						</div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Todo</h4>
                                    <div class="card-content">
                                        <div class="todo-list">
                                            <div class="tdl-holder">
                                                <div class="tdl-content">
                                                    <ul>
                                                        
                                                    </ul>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                    <input type="text" class="form-control" id="myTodo" placeholder="Type a ask">
                                                    </div>
                                                    <div class="col-md-4">
                                                    <button class="btn btn-success btnTodo" style="margin-top:40px;">Add ToDo</button>
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
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    
	<script src="js/lib/calendar-2/moment.latest.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/semantic.ui.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/prism.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/pignose.calendar.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/pignose.init.js"></script>

    <script>

        $(document).ready(function(){

            var toDo = [];
            var flavor = ["warning","success","danger","primary"];
            
            $(document).on("click", ".btnTodo", function(){
                var randInt = Math.floor(Math.random() * flavor.length);  
                var newTodo = $("#myTodo").val();
                toDo.push(newTodo);
                $(".tdl-content").append(' <li><label><input type="checkbox"><i class="bg-'+flavor[randInt]+'"></i><span>'+newTodo+'</span><a class="ti-close"></a></label></li>');
            })

            $(document).on("click", ".ti-close", function(){
                var tdl = $(this).closest("li").find("span").html();

                var tdlIndex = toDo.indexOf(tdl);
                toDo.splice(tdlIndex, 1);
                $(this).closest("li").remove();
            })

        })
    </script>
</body>

</html>