<?php 

    require_once 'db_connect.php';

    function getAllBus(){
        $conn = db_conn();
        $query = "SELECT * FROM `buses`";
        try{
            $results = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $results;
    }

    function getBus($id){
        $conn = db_conn();
        $query = "SELECT * FROM `buses` WHERE `id`='$id'";
        try{
            $result = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $result;
    }

    function getBusOfOperator($operator){
        $conn = db_conn();
        $query = "SELECT * FROM `buses` WHERE `operator`='$operator'";
        try{
            $result = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $result;
    }

    function getBusOfCoach($coach){
        $conn = db_conn();
        $query = "SELECT * FROM `buses` WHERE `coach`='$coach'";
        try{
            $result = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $result;
    }

    function addBus($bus){
        $coach = $bus['coach'];
        $source = $bus['source'];
        $dest = $bus['dest'];
        $time = $bus['time'];
        $fare = $bus['fare'];
        $operatorEmail = $bus['operatorEmail'];

        $conn = mysqli_connect('localhost', 'root', '', 'etickets');
        $query = "INSERT INTO buses (coach, source, dest, time, operator, fare) VALUES ('$coach', '$source', '$dest', '$time', '$operatorEmail', '$fare')";
        if(mysqli_query($conn, $query)){
            $conn = null;
            return true;
        }
        $conn = null;
        return false;
    }

    

?>