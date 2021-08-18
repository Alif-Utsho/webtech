<?php 

    require_once('../api/tickets.php');

    if(isset($_POST['confirmbook'])){
        $ticket['customer'] = $_POST['customer'];
        $ticket['operator'] = $_POST['operator'];
        $ticket['coach'] = $_POST['coach'];
        $ticket['date'] = $_POST['date'];
        $ticket['time'] = $_POST['time'];
        $ticket['seats'] = $_POST['seats'];
        $ticket['fare'] = $_POST['fare'];
        $ticket['txnid'] = $_POST['txnid'];
        $ticket['pmethod'] = $_POST['pmethod'];

        $res = bookTicket($ticket);
        if($res){
            echo "<h1>Ticket booked</h1> <br> <br>";
            echo "You are now redirecting to home page...";
            header("Refresh:3, url=http://localhost/eTickets/");
        }
        else{
            echo "Something went wrong";
        }
        
    }


?>