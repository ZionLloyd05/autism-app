<?php
 require_once "../../includes/symptom.php";
 require_once "../../includes/doctor.php";
 require_once "../../includes/patient.php";
 require_once "../../includes/appointment.php";

    if(isset($_POST['uid'])){
        $uid = $_POST['uid'];
        global $database;

        $result = Doctor::doc_info($uid);
        $row = $database->fetch_array($result);
        echo json_encode($row);
    }

    if(isset($_POST['symptid'])){
        $symptomId = $_POST['symptid'];

        Symptom::toggleStatus($symptomId);
        echo "ok";
    }

    if(isset($_POST['patientid'])){
        $patient = new Patient();

        $patientid = $_POST['patientid'];
        $result = $patient->get_full_info($patientid);

        echo json_encode($result);
    }

    if(isset($_POST['patient_id']) && !empty($_POST['time'])){
        // echo $_POST['time'];
        $newApp = new Appointment();

        if(!empty($_POST['appointid'])){
            $newApp->id = $_POST['appointid'];
        }
        $newApp->doctorid = $_POST['userid'];
        $newApp->patientid = $_POST['patient_id'];
        $newApp->fixeddate = $_POST['sdate'];
        $newApp->fixedtime = $_POST['time'];
        $newApp->note = $_POST['note'];

        if($newApp->save()){
            echo "Appointment saved successfully";
        }
        // echo json_encode($newApp);
    }

    if(isset($_POST['appid'])){
        $appId = $_POST['appid'];

        Appointment::toggleStatus($appId);
        echo "ok";
    }

    if(isset($_POST['app_id'])){
        global $database;

        $app_id = $_POST['app_id'];
        $get_app = Appointment::find_by_id3($app_id);
        $result = $database->fetch_array($get_app);

        echo json_encode($result); 
    }

    if(isset($_POST['apId'])){
        $appid = $_POST['apId'];

        if(Appointment::delete_item($appid)){
            echo "Appointment Deleted Successfully";
        }else{
            echo "Oops, something went wrong";
        }
    }

    if(isset($_POST['sname']) && !empty($_POST['sname'])){
        // echo $_POST['time'];
        $newSymptom = new Symptom();

        if(!empty($_POST['sympid'])){
            $newSymptom->id = $_POST['sympid'];
        }
        $newSymptom->doctorid = $_POST['userId'];
        $newSymptom->name = $_POST['sname'];

        if($newSymptom->save()){
            echo "Symptom saved successfully";
        }
        // echo json_encode($newApp);
    }

    if(isset($_POST['e_sympt'])){
        global $database;

        $e_sympt = $_POST['e_sympt'];
        $get_sym = Symptom::find_by_id3($e_sympt);
        $result = $database->fetch_array($get_sym);

        echo json_encode($result); 
    }

    if(isset($_POST['d_sympt'])){
        $d_sympt = $_POST['d_sympt'];

        if(Symptom::delete_item($d_sympt)){
            echo "Symptom Deleted Successfully";
        }else{
            echo "Oops, something went wrong";
        }
    }
?>