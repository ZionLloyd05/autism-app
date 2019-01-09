<?php
require_once "../includes/symptom.php";
 if(isset($_POST['selectedSymptoms']) && !empty($_POST['selectedSymptoms'])){

    $selectedSymptoms = array();
    $validSymptoms = array();
    $validSymptomsArr = array();
    $selectedSymptoms = $_POST['selectedSymptoms'];

    $symptom = new Symptom();
    $validSymptoms = $symptom->find_valid_symptoms();
    while($row = $database->fetch_array($validSymptoms)){
        array_unshift($validSymptomsArr, $row['name']);
    }
    
    $arr_diff = array_diff($validSymptomsArr, $selectedSymptoms);
    
    if(count($selectedSymptoms) < count($validSymptomsArr)){
        // 1 -> Not Autistic
        $returnBox = array(
            "res" => "1"
        );
        echo json_encode($returnBox);
    }else{
        $sym_diff = array_diff($validSymptomsArr, $selectedSymptoms);
        if(count($sym_diff) > 0){
            // 2 -> larger but still not Autistic
            $returnBox = array(
                "res" => "2"
            );
            echo json_encode($returnBox);
        }else{
            // 3 -> Autistic
            $returnBox = array(
                "res" => "3"
            );
            echo json_encode($returnBox);
        }
    }
    
 }else{
     // 3 -> Autistic
     $returnBox = array(
        "res" => "4"
    );
    echo json_encode($returnBox);
 }
?>