<?php

  require_once "includes/patient.php";
  require_once "includes/doctor.php";
  require_once "includes/symptom.php";
  require_once "includes/doctor.php";
  
  ##Checking if the user has logged in recently
  if($session->is_signed_in()){

        ##Checking what type of user
        $confirm_doc = Doctor::get_user_type($session->user_id);
        if($confirm_doc == true){
        header("Location: doctor/index.php");
            }

        $confirm_pat = Patient::get_user_type($session->user_id);
        if($confirm_pat == true){
        header("Location: patient/index.php");
            }
    }

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home | HMS</title>

    <!-- Bootstrap core CSS -->
    <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>

    <!-- Custom fonts for this template -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="assets/css/landing-page.css" rel="stylesheet">

    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
   
  </head>

  <body>

    <!-- Masthead -->
    <header class="masthead text-white text-left">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-10 mx-left">
            <p class="mb-5">
              <ul style="list-style:none;">
                <li style="font-size:45px;">Medic Recommendation System </li>
                <br/>
                <li style="font-size:25px;">Welcome, </li>
              </ul>
            </p>
          </div>
          <div class="col-md-9 col-lg-9 col-xl-10 text-left">
            <div class="col-md-6 d-flex ">
                <a id="docSignup" data-toggle="modal" data-target="#docMod" class="px-3 btn btn-primary text-white" href="#"><i class="fas fa-user-plus"></i> Doctor Registeration</a>
              <a id="patSignup" data-toggle="modal" data-target="#patient_selection" class="px-3 btn btn-primary text-white" href="#"><i class="fas fa-user-plus"></i> Patient Registeration</a>
              <a id="loginbtn" data-toggle="modal" data-target="#loginMod" class="px-3 btn btn-primary text-white" href="#"><i class="fas fa-sign-in-alt"></i> Log in</a>
            </div>
          </div>
        </div>
      </div>
    </header>


  <!-- Patient Reg Modal -->
  <div class="modal fade" id="patMod" tabindex="-2" role="dialog" aria-labelledby="Lecturer" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #0a455c !important;color: white;">
        <h5 class="modal-title" id="Lecturer"><i class="fas fa-user-plus"></i> New Patient Registration</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mb-2">
              <label for="fname">Patient First Name</label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="pfname" placeholder="Zion" required>
                  <div class="invalid-feedback" style="width: 100%;">
                      Your username is required.
                  </div>
              </div>
            </div>
            <div class="col-md-4 mb-2">
                  <label for="lname">Patient Last Name</label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control" id="plname" placeholder="Mark" required>
                      <div class="invalid-feedback" style="width: 100%;">
                          Your username is required.
                      </div>
                  </div>
            </div>
            <div class="col-md-4 mb-2">
                  <label for="lname">Date of Birth</label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="date" class="form-control" id="pdob" placeholder="Mark" required>
                      <div class="invalid-feedback" style="width: 100%;">
                          Your username is required.
                      </div>
                  </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-2">
              <label for="fname">Blood Group</label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="bgroup" placeholder="Zion" required>
                  <div class="invalid-feedback" style="width: 100%;">
                      Your username is required.
                  </div>
              </div>
            </div>
            <div class="col-md-4 mb-2">
                  <label for="lname">Genotype</label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control" id="geno" placeholder="Mark" required>
                      <div class="invalid-feedback" style="width: 100%;">
                          Your username is required.
                      </div>
                  </div>
            </div>
        </div>
       
       <hr/>
       <!-- Guardian Info -->
       <div class="row">
            <div class="col-md-4 mb-2">
              <label for="fname">Guardian First Name</label>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="gfname" placeholder="Zion" required>
                  <div class="invalid-feedback" style="width: 100%;">
                      Your username is required.
                  </div>
              </div>
            </div>
            <div class="col-md-4 mb-2">
                  <label for="lname">Guardian Last Name</label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control" id="glname" placeholder="Mark" required>
                      <div class="invalid-feedback" style="width: 100%;">
                          Your username is required.
                      </div>
                  </div>
            </div>
            <div class="col-md-4 mb-2">
                  <label for="lname">Email</label>
                  <div class="input-group">
                      <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                      <input type="email" class="form-control" id="email" placeholder="Mark" required>
                      <div class="invalid-feedback" style="width: 100%;">
                          Your username is required.
                      </div>
                  </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4 mb-2">
                <label for="phone">Phone Number</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control" id="phone" placeholder="08134854527" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <label for="password">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                    </div>
                    <input type="password" class="form-control" id="password" placeholder="Password" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <label for="rpassword">Re-type Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                    </div>
                    <input type="password" class="form-control" id="rpassword" placeholder="re-Password" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                    </div>
                </div>
            </div>
        </div>

        <hr/>

        <div class="row mt-3">
            <div class="col-lg-3">
                <div class="input-group">
                    <input type="text" readonly="readonly" id="captacode" class="form-control recapture" value="<?php echo (Patient::randomString(5)); ?>">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="input-group">
                    <input type="text" id="usercapta" class="form-control" placeholder="Enter 5 digit code">
                </div>
            </div>
        </div>

      </div>
      <div class="modal-footer d-flex flex-row justify-content-between">
        <p class="preg_loading" style="display:none;">Registration in Progress <span><img style="width:15%;" src="assets/img/gif4.gif"/></span></p>
        <button type="button" class="pregbtn btn btn-primary">Register</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Doctor Reg Modal -->
<div class="modal fade" id="docMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"  style="background-color: #0a455c !important;color: white;">
          <h5 class="modal-title" id="exampleModalLabel">Doctor Registration</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
                <div class="col-md-6 mb-2">
                <label for="fname">First Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="dfname" placeholder="Zion" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                    </div>
                </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="lname">Last Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" id="dlname" placeholder="Mark" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Your username is required.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-2">
                <label for="email">Email</label>
                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="text" class="form-control" id="demail" placeholder="zion@gmail.com" required>
                <div class="invalid-feedback" style="width: 100%;">
                    Your username is required.
                </div>
                </div>
            </div>

            <div class="mb-2">
                <label for="phone">Phone Number</label>
                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="text" class="form-control" id="dphone" placeholder="08134854527" required>
                
                </div>
            </div>

            <div class="mb-2">
                <label for="password">Password</label>
                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                </div>
                <input type="password" class="form-control" id="dpassword" placeholder="Password" required>
                
                </div>
            </div>

            <div class="mb-2">
                <label for="rpassword">Re-type Password</label>
                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                </div>
                <input type="password" class="form-control" id="drpassword" placeholder="re-Password" required>
                
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="text" readonly="readonly" id="dcapta1" class="form-control recapture" value="<?php echo (Patient::randomString(5)); ?>">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group">
                        <input type="text" id="dcapta2" class="form-control" placeholder="Enter 5 digit code">
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer d-flex flex-row justify-content-between">
          <p class="docLoading" style="display:none;">Registration in Progress <span><img style="width:15%;" src="assets/img/gif4.gif"/></span></p>
          <button id="docReg" type="button" class="btn btn-primary">Register</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"  style="background-color: #0a455c !important;color: white;">
          <h5 class="modal-title" id="exampleModalLabel">User Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-12">

                <form class="form-signin" action="index.php" method="post">
                          
                    <div class="form-side">
                    
                      <div class="mb-2">
                          <label for="email">Email</label>
                          <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                          </div>
                          <input type="text" class="form-control" id="lgn_email" name="email" placeholder="zion@gmail.com" required>
                          <div class="invalid-feedback" style="width: 100%;">
                              Your username is required.
                          </div>
                          </div>
                      </div>

                      <div class="mb-2">
                          <label for="password">Password</label>
                          <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                          </div>
                          <input type="password" class="form-control" id="lgn_password" name="password" placeholder="Password" required>
                          <div class="invalid-feedback" style="width: 100%;">
                              Your username is required.
                          </div>
                          </div>
                      </div>

                      <div class="mb-2">
                          <label for="password">Login As ?</label>
                          <div class="input-group">
                          <select class="custom-select d-block w-100" id="lgn_usertype" required="">
                            <option value="">Choose...</option>
                            <option>Doctor</option>
                            <option>Patient</option>
                          </select>
                          </div>
                      </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer d-flex flex-row justify-content-between">
        <p class="lgn_loading" style="display:none;">Validating Credentials <span><img style="width:15%;" src="assets/img/gif4.gif"/></span></p>
        <button type="button" id="loginBtn" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
</div>
</div>


<!-- Patient Selection -->
<div class="modal fade" id="patient_selection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header"  style="background-color: #0a455c !important;color: white;">
          <h5 class="modal-title" id="exampleModalLabel">Select Symptom</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="selectedSympt">
                <!-- <p>Select the symptoms affecting patient...</p> -->
            </div>	
            <hr>
            <div class="autSympt">
                <?php 
                    $counter = 0;
                    $symptoms = Symptom::find_all();
                    while($row = $database->fetch_array($symptoms)){?>
                        <button type='button' btn-name='<?php echo $row['name']; ?>' style='margin:10px;' class='symptom btn btn-secondary'><i class="fas fa-plus"></i> <?php echo $row['name']; ?></button>
                    <?php }?>
            </div>				
        </div>
        <div class="modal-footer d-flex flex-row justify-content-between">
        <p class="sym_loading" style="display:none;">Checking Symptoms <span><img style="width:15%;" src="assets/img/gif4.gif"/></span></p>
        <button type="button" id="submitSymptBtn" class="btn btn-primary">Submit Symptoms</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
</div>

    <!-- Bootstrap core JavaScript -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    

   <script>
       $(document).ready(function(){

        var selectedSymptoms = [];
        
        //adding of symptoms handler
        $(document).on("click", ".symptom", function(){
            var btn = $(this);
            var btnVal = btn.attr("btn-name");
            selectedSymptoms.push(btnVal);
            // $('.selectedSympt').empty();
            $('.selectedSympt').append("<button type='button' btn-name='"+btnVal+"' style='margin:10px;' class='userSymptoms btn btn-secondary'>"+btnVal+" <i class='fas fa-minus'></i></button>");
            btn.remove();

            // next task
            // i wanna add plus icon and cancel icon, data-name will be an attr holding the name..
            //***********done*********-----/
        })
        
        //removing of symptoms handler
        $(document).on("click", ".userSymptoms", function(){
            var btn = $(this);
            var btnVal = btn.attr("btn-name");

            var index = selectedSymptoms.indexOf(btnVal);
            selectedSymptoms.splice(index, 1);
            $('.autSympt').append("<button type='button' btn-name='"+btnVal+"' style='margin:10px;' class='symptom btn btn-secondary'><i class='fas fa-plus'></i> "+btnVal+"</button>")
            btn.remove();
        })

        //submit symptoms handler
        $(document).on("click", "#submitSymptBtn", function(){
            
            var btn = $(this);
            
            $.ajax({
                url: "ajaxfiles/checkautism.php",
                method: "POST",
                data: {
                    'selectedSymptoms' : selectedSymptoms
                },
                dataType: "json",
                beforeSend: function(){
                    $('.sym_loading').show();
                    btn.hide();
                },
                success: function(data){
                    $('.sym_loading').hide();
                    btn.show();
                    if(data.res == 1){
                        //replace with => swal("****************")
                        // alert("Not Autistic");
                        swal("You are not Autistic");
                        $('.sym_loading').empty();
                        $('.sym_loading').html("Result Computed");
                    }else if(data.res == 2){
                        swal("You are not Autistic")
                        // alert("Not Still Autistic");
                        $('.sym_loading').empty();
                        $('.sym_loading').html("Result Computed");
                    }else if(data.res == 4){
                        swal("No selection was made!")
                        // alert("Not Still Autistic");
                        $('.sym_loading').empty();
                        $('.sym_loading').html("Result Computed");
                    }else if(data.res == 3){
                        swal("Proceed to register")
                        $('.sym_loading').empty();
                        $('.sym_loading').html("Result Computed");
                        $('#patient_selection').modal('hide');
                        $('#patMod').modal('show');
                    }

                }
            })
        })

        $(document).on("click", ".pregbtn", function(){

            var btn = $(this);
            
            var pfname = $.trim($('#pfname').val());
            var plname = $.trim($('#plname').val());
            var pdob = $.trim($('#pdob').val());
            var bgroup = $.trim($('#bgroup').val());
            var geno = $.trim($('#geno').val());
            var gfname = $.trim($('#gfname').val());
            var glname = $.trim($('#glname').val());
            var email = $.trim($('#email').val());
            var phone = $.trim($('#phone').val());
            var password = $.trim($('#password').val());
            var rpassword = $.trim($('#rpassword').val());
            var captacode = $.trim($('#captacode').val());
            var usercapta = $.trim($('#usercapta').val());

            // alert(pfname+" "+plname+" "+pdob+" "+geno+" "+gfname+" "+glname+" "+email+" "+phone+" "+password+" "+rpassword+" "+captacode+" "+usercapta);
            if( usercapta != captacode ){
                swal("Seceret Code Incorrect", "Kindly re-enter code", "error");
                // alert("Seceret Code Incorrect");
            }else if(rpassword != password){
                swal("Password Match Failed", "Kindly re-enter password", "error");
                // alert("Password Match Failed");
            }else if(pfname == "" || plname == "" || pdob == ""  || bgroup == ""
                     || geno == "" || gfname == "" || glname == "" || email == ""
                     || password == "")
            {   
                swal("Incomplete Information", "Kindly fill form completely", "error");
                // alert("incomplete information");
            }else if(isEmailAddress(email) != true){
                swal("Invalid Email", "Kindly fill properly", "error");
            }else if(isPhoneNumber(phone) != true){
                swal("Invalid Phone", "Kindly fill properly", "error");
            }else{
                $.ajax({
                    url: "ajaxfiles/registration.php",
                    method: "POST",
                    data: {
                        "pfname":pfname, "plname":plname,
                        "pdob":pdob, "bgroup":bgroup,
                        "geno":geno, "gfname":gfname,
                        "glname":glname, "email":email,
                        "password":password, "phone":phone
                    },
                    dataType: "json",
                    beforeSend: function(){
                        $('.preg_loading').show();
                        btn.hide();
                    },
                    success:function(data){
                        if(data.status == 0){
                            $('.preg_loading').hide();
                            btn.show();
                            // use swal
                            swal("Email already exist", "", "error");
                            // alert("Email already exist");
                        }else if(data.status == 1){
                            $('.preg_loading').empty();
                            $('.preg_loading').html("Registration was successfull..");
                            swal("Registeration was successfull", "", "success");
                            // alert("Registeration was successfull");
                            $('#patMod').modal('hide');
                            $('#loginMod').modal('show');
                        }else{
                            swal("Oops, Something went wrong", "", "error")
                            // alert("Oops, Something went wrong");
                        }
                    }
                })
            }

        })


        $(document).on("click", "#docReg", function(){

            var btn = $(this);
            
            var fname = $.trim($('#dfname').val());
            var lname = $.trim($('#dlname').val());
            var demail = $.trim($('#demail').val());
            var phone = $.trim($('#dphone').val());
            var password = $.trim($('#dpassword').val());
            var rpassword = $.trim($('#drpassword').val());
            var captaSystem = $('#dcapta1').val();
            var captaUser = $('#dcapta2').val();



            if( captaUser != captaSystem ){
                swal("Seceret Code Incorrect", "Kindly re-enter code", "error");
            }else if(rpassword != password){
                swal("Password Match Failed", "Kindly re-enter password", "error");
            }else if(fname == "" || lname == "" || demail == "" || phone == ""){
                swal("Incomplete Information", "Kindly fill form completely", "error");
            }else if(isEmailAddress(demail) != true){
                swal("Invalid Email", "Kindly fill properly", "error");
            }else if(isPhoneNumber(phone) != true){
                swal("Invalid Phone", "Kindly fill properly", "error");
            }else{
                //ajax code
                $.ajax({
                    url: "ajaxfiles/registration.php",
                    method: "POST",
                    data: {'firstname':fname, 'lastname':lname, 'demail':demail, 'phone':phone, 'password':password},
                    dataType: "json",
                    beforeSend: function(){
                        $('.docLoading').show();
                        btn.hide();
                    },
                    success:function(data){
                        if(data.status == 1){
                          $('.docLoading').empty();
                          $('.docLoading').html("Registration was successfull..");
                          swal("Registration was Successfull", "Proceed to Login", "success");
                        //   alert("Registration was Successfull");
                          $('#docMod').modal('hide');
                          $('#loginMod').modal('show');
                        }else if(data.status == 0){
                            $('.docLoading').hide();
                            btn.show();
                          swal("Email Already Exist", "Kindly try again", "error");                         
                        }
                    }
                })
            }
        })

        function isEmailAddress(str) {
            var pattern =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return pattern.test(str);  // returns a boolean 
        }
        
        function isPhoneNumber(str) {
            var pattern =/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
            return pattern.test(str);  // returns a boolean 
        }
        

        $(document).on("click", "#loginBtn", function(){

            var btn = $(this);

            var email = $('#lgn_email').val();
            var password = $('#lgn_password').val();
            var usertype = $('#lgn_usertype').val();

            $.ajax({
                url: "ajaxfiles/verifyLogin.php",
                method: "POST",
                data: {
                    'email':email, 
                    'password':password,
                    'usertype':usertype
                },
                dataType: "json",
                beforeSend: function(){
                    $('.lgn_loading').show();
                    btn.hide();
                },
                success:function(data){
                    if(data.response == 1){
                        $('.lgn_loading').empty();
                        $('.lgn_loading').html("Redirecting You!");
                        // swal({
                        //     title: "Login was successfull",
                        //     text: "We're Redirecting You!",
                        //     timer: 4000,
                        //     showConfirmButton: false
                        // }); 
                        // alert("Doctor login successfull");
                        swal("Doctor login successfull","Redirecting You!","success");
                    window.location.href = "doctor/index.php";
                    }else if(data.response == 2){
                        $('.lgn_loading').empty();
                        $('.lgn_loading').html("Redirecting You!");
                        // swal({
                        //     title: "Login was successfull",
                        //     text: "We're Redirecting You!",
                        //     timer: 4000,
                        //     showConfirmButton: false
                        // }); 
                        // alert("Patient login successful");
                        swal("Patient login successful","Redirecting You!","success");
                    window.location.href = "patient/index.php";
                    }else{
                        $('.lgn_loading').hide();
                        btn.show();
                        // alert("Incorrect details");
                        swal("Incorrect details","Try Again","error");
                    }
                }
            })
            
        })
    })
   </script>
  </body>

</html>