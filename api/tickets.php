<?php 

    require_once 'db_connect.php';

    function getAllTickets(){
        $conn = db_conn();
        $query = "SELECT * FROM `tickets`";
        try{
            $results = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $results;
    }

    function bookTicket($ticket){

        $customer = $ticket['customer'];
        $operator = $ticket['operator'];
        $coach = $ticket['coach'];
        $date = $ticket['date'];
        $time = $ticket['time'];
        $seats = $ticket['seats'];
        $fare = $ticket['fare'];
        $txnid = $ticket['txnid'];
        $pmethod = $ticket['pmethod'];

        $conn = db_conn();
        $query = "INSERT INTO `tickets` (customer, operator, coach, date, time, seats, fare, txnid, pmethod) VALUES ('$customer', '$operator', '$coach','$date','$time', '$seats','$fare','$txnid','$pmethod')";

        if(mysqli_query($conn, $query)){
            $conn = null;
            return true;
        }
        $conn = null;
        return false;
    }

    function getTicketsWithQuery($query){
        $conn = db_conn();
        try{
            $results = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $results;
    }

    function getTicketsOfUser($user){
        $conn = db_conn();
        $query = "SELECT * FROM `tickets` WHERE customer='$user'";
        try{
            $results = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $results;
    }


?>