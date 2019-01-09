<?php 
    require_once '../includes/session.php';
    $session->logout();
    header("Location: ../index.php");
?>