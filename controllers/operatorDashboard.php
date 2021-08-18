<?php

    require_once('../api/buses.php');

    $coach = $source = $dest = $time = $operatorEmail = "";
    $coach_err = $source_err = $dest_err = $time_err = "";

    if(isset($_POST['addbus'])){
        $coach = $_POST['coach'];
        $source = $_POST['source'];
        $dest = $_POST['dest'];
        $time = $_POST['time'];
        $fare = $_POST['fare'];
        $operatorEmail = $_POST['operator'];

        // session_start();
        // if(isset($_SESSION['operatorEmail'])) $operatorEmail = $_SESSION['operatorEmail'];

        if(!$coach) $coach_err = "* Please provide a Coach Name";
        if(!$source) $source_err = "* Please provide a Source";
        if(!$dest) $dest_err = "* Please provide a Destination";
        if(!$time) $time_err = "* Please provide a time";

        $res = getBusOfCoach($coach);
        if(mysqli_num_rows($res)>0){
            echo "<h1>Coach name cannot be Duplicate, Try with another coach name <br> <br> </h1>";
            echo "You will automatically redirected the home page withing 5 seconds";
            header('Refresh:5, url=http://localhost/eTickets/views/operatorDashboard.php');
            return;
        }

        if(!$coach_err && !$source_err && !$dest_err && !$time_err){
            // Inserting data into Database
            $conn = mysqli_connect('localhost', 'root', '', 'etickets');
            $query = "INSERT INTO buses (coach, source, dest, time, operator, fare) VALUES ('$coach', '$source', '$dest', '$time', '$operatorEmail', '$fare')";
            if(mysqli_query($conn, $query)){
                mysqli_close($conn);
                $coach = $source = $dest = $time = "";
            }
        }
    }
    if(isset($_POST['signout'])){
        
        session_start();
        session_unset();
        session_destroy();
        header('Refresh:0, url=http://localhost/eTickets/views/login.php');
        return;
    }

    if(isset($_POST['deletebus'])){
        $coachId = $_POST['coachid'];

        $conn = mysqli_connect('localhost', 'root', '', 'etickets');
        $query = "DELETE FROM buses WHERE id = $coachId";
        if(mysqli_query($conn, $query)){
            mysqli_close($conn);
        }
    }

    if(isset($_POST['editbus'])){
        $id = $_POST['busid'];
        $source = $_POST['source'];
        $dest = $_POST['dest'];
        $time = $_POST['time'];
        $fare = $_POST['fare'];

            // Updating data into Database
        $conn = mysqli_connect('localhost', 'root', '', 'etickets');
        $query = "UPDATE buses SET source='$source', dest='$dest', time='$time', fare='$fare' WHERE id='$id'";
        if(mysqli_query($conn, $query)){
            mysqli_close($conn);
        }
    }

    header('Refresh:0, url=http://localhost/eTickets/views/operatorDashboard.php');
?>