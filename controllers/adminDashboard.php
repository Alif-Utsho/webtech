<?php

    $coach = $source = $dest = $time = $operatorEmail = "";

    if(isset($_POST['addOperator'])){
        $type = "operator";
        $gender = "male";
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        

        // Inserting data into Database
        $conn = mysqli_connect('localhost', 'root', '', 'etickets');
        $query = "INSERT INTO `users` (type, name, phone, email, password, gender) VALUES ('$type', '$name', '$phone', '$email', '$hash', '$gender')";
        if(mysqli_query($conn, $query)){
            mysqli_close($conn);
            echo "Operator Added";
            header("Refresh:5, url=http://localhost/eTickets/views/login.php");
        }
        else{
            echo "Something went wrong";
            return;
        }
    }

    if(isset($_POST['signout'])){
        
        session_start();
        session_unset();
        session_destroy();
        header('Refresh:0, url=http://localhost/eTickets/views/login.php');
        return;
    }

    if(isset($_POST['deleteOperator'])){
        $operatorId = $_POST['operatorid'];

        $conn = mysqli_connect('localhost', 'root', '', 'etickets');
        $query = "DELETE FROM users WHERE id = $operatorId";
        if(mysqli_query($conn, $query)){
            mysqli_close($conn);
        }
    }

    if(isset($_POST['updateOperator'])){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        // Updating data into Database
        $conn = mysqli_connect('localhost', 'root', '', 'etickets');
        $query = "UPDATE users SET name='$name', phone='$phone', email='$email' WHERE id='$id'";
        if(mysqli_query($conn, $query)){
            mysqli_close($conn);
        }
    }

    header('Refresh:0, url=http://localhost/eTickets/views/operatorDashboard.php');
?>