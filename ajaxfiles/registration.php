<?php
    require_once "../includes/doctor.php";
    require_once "../includes/patient.php";
    require_once "../includes/database.php";

    //instantiatng new doctor
    $doctor = new Doctor();

    //instantiating new patient
    $patient = new Patient();
    
    //checking is any value was posted -- Doctor Registeration
    if( !empty($_POST['demail'])){
        
        $email = $database->escape_val($_POST['demail']);

        $result = $doctor->check_if_email_exist($email);

        if($result == 1){
            $resp = array(
                "status" => "0"
            );

            echo json_encode($resp);

        }else{
            
            //assigning post to varibles
            $firstname = $database->escape_val($_POST['firstname']);
            $lastname = $database->escape_val($_POST['lastname']);
            $phone = $database->escape_val($_POST['phone']);
            $password = $database->escape_val($_POST['password']);
            $hashedPass = $database->cryptPass($password);
            $doctorId = substr($lastname,0,3)."_".rand(000, 999)."".substr($phone,8,11);

            //assigning variables to instantiated object property
            $doctor->doctorId = $doctorId;
            $doctor->firstname = $firstname;
            $doctor->lastname = $lastname;
            $doctor->password = $hashedPass;
            $doctor->email = $email;
            $doctor->phone = $phone;

            //persisting object to database..
            if($doctor->save()){
                $resp = array(
                    "status" => "1"
                );

                echo json_encode($resp);
            }
        }

    }

    //checking is any value was posted -- Patient Registeration
    if( !empty($_POST['geno'])){

        $email = $database->escape_val($_POST['email']);

        $result = $doctor->check_if_email_exist($email);

        if($result == 1){
            $resp = array(
                "status" => "0"
            );

            echo json_encode($resp);

        }else{

            $pfirstname = $database->escape_val($_POST['pfname']);
            $plastname = $database->escape_val($_POST['plname']);
            $dob = $database->escape_val($_POST['pdob']);
            $bloodgroup = $database->escape_val($_POST['bgroup']);
            $genotype = $database->escape_val($_POST['geno']);
            $gfirstname = $database->escape_val($_POST['gfname']);
            $glastname = $database->escape_val($_POST['glname']);
            $password = $database->escape_val($_POST['password']);
            $hashedPass = $database->cryptPass($password);
            $email = $database->escape_val($_POST['email']);
            $phone = $database->escape_val($_POST['phone']);
            $patientId = substr($plastname, 0, 3)."_".rand(000, 999)."".substr($phone, 8, 11);

            $patient->patient_id = $patientId;
            $patient->pfirstname = $pfirstname;
            $patient->plastname = $plastname;
            $patient->dob = $dob;
            $patient->bloodgroup = $bloodgroup;
            $patient->genotype = $genotype;
            $patient->gfirstname = $gfirstname;
            $patient->glastname = $glastname;
            $patient->password = $hashedPass;
            $patient->email = $email;
            $patient->phone = $phone;

            //persisting object to database..
            if($patient->save()){
                $resp = array(
                    "status" => "1"
                );

                echo json_encode($resp);
            }
        }
        
    }
?>
