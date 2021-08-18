<?php

$name = $phone = $gender = $email = $password = $repass = "";
$name_err = $phone_err = $gender_err = $email_err = $pass_err = $repass_err = "";

if(isset($_POST)){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repass = $_POST['repass'];
}

if(empty($name)) $name_err = "Please provide an Name";

if(empty($phone))  $phone_err = "Please provide a Phone";

if(empty($gender)) $gender_err = "Please Select a Gender";

if(empty($email)) $email_err = "Please provide an E-mail";
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) $email_err = "Please provide a valid E-mail";

if(empty($password)) $pass_err = "Please provide a Password";
elseif(strlen($password) < 6) $pass_err = "Password should be greater than 6";
elseif($password != $repass) $repass_err = "Password doesn't match";


function hasError($name_err, $phone_err, $gender_err, $email_err, $pass_err, $repass_err){
    if(strlen($name_err) !== 0 || strlen($phone_err) !== 0 || strlen($gender_err) !== 0 || 
        strlen($email_err) !== 0 || strlen($pass_err) !== 0 || strlen($repass_err) !== 0){ 
            return true;
        }
        else return false;
}

if(!hasError($name_err, $phone_err, $gender_err, $email_err, $pass_err, $repass_err)){
    $conn = mysqli_connect('localhost', 'root', '', 'etickets');
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, phone, email, password, gender) VALUES ('$name', '$phone', '$email', '$hash', '$gender')";
    if(mysqli_query($conn, $query)){
        echo "Registration succeded";
        mysqli_close($conn);
        header('Location: ../views/customerDashboard.php');
    }
}

include '../views/registration.php';


?>
