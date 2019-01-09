<?php
 require_once "../../includes/symptom.php";
 require_once "../../includes/doctor.php";
 require_once "../../includes/patient.php";

    if(isset($_POST['symptid'])){
        $symptomId = $_POST['symptid'];

        Symptom::toggleStatus($symptomId);
        echo "ok";
    }

    if(isset($_POST['pid'])){
        $pid = $_POST['pid'];
        global $database;

        $result = Patient::get_full_info($pid);
        echo json_encode($result);
    }

?>