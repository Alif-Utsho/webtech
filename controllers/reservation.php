<?php

    if(isset($_POST['check'])){
        if(isset($_POST['coach'])){
            $checkCoach = $_POST['coach'];
            $checkDate = $_POST['date'];
            include("../views/reservation.php");
        }
        else{
            $coach_err = "Please select a coach first";
            include("../views/operatorDashboard.php");
            
        }

    }

?>