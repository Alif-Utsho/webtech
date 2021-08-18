<?php

    $source = $dest = "";
    $source_err = $dest_err = "";

    if(isset($_GET['search'])){
        $source = $_GET['source'];
        $dest = $_GET['dest'];
        $date = $_GET['date'];

        if(!$source) $source_err = "Please provide a Source";
        if(!$dest) $dest_err = "Please provide a Destination";

        if($source_err && $dest_err){
            include '../views/customerDashboard.php';
        }
        else{
            $conn = mysqli_connect('localhost', 'root', '', 'etickets');
            $query = "SELECT * FROM buses WHERE source='$source' AND dest='$dest'";
            
            $result = mysqli_query($conn, $query);
            $count = mysqli_num_rows($result);
            
            include '../views/customerDashboard.php';
        }
    }

    if(isset($_POST['signout'])){
        
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../views/login.php');
    }

?>