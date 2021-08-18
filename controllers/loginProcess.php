<?php

$email = $password = "";
$email_err = $pass_err = "";

if(isset($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];
}

if(empty($email)) $email_err = "Please provide an E-mail";
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) $email_err = "Please provide a valid E-mail";

if(empty($password)) $pass_err = "Please provide a Password";
elseif(strlen($password) < 6) $pass_err = "Password should be greater than 6";


if(strlen($email_err) === 0 && strlen($pass_err) === 0){
    $conn = mysqli_connect('localhost', 'root', '', 'etickets');
    $query = "SELECT * FROM users WHERE email='$email'";
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    $hash = $row["password"];
    $verify = password_verify($password, $hash);

    if($verify && $row["type"]==='customer'){
        session_start();
        $_SESSION['customerEmail'] = $email;
        mysqli_close($conn);
        header('Location: ../views/customerDashboard.php');
        return;
    }
    elseif($verify && $row["type"]==='operator'){
        session_start();
        $_SESSION['operatorEmail'] = $email;
        $_SESSION['operatorName'] = $row["name"];
        mysqli_close($conn);
        header('Location: ../views/operatorDashboard.php');
        return;
    }
    elseif($verify && $row["type"]==='admin'){
        session_start();
        $_SESSION['adminEmail'] = $email;
        $_SESSION['adminName'] = $row["name"];
        mysqli_close($conn);
        header('Location: ../views/adminDashboard.php');
        return;
    }
    else $pass_err = "Invalid Credintial";
}


include '../views/login.php';


?>
