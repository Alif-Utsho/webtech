<?php

    require_once 'db_connect.php';

    function getAllUsers(){
        $conn = db_conn();
        $query = "SELECT * FROM `users`";
        try{
            $results = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        // $rows = mysqli_fetch_array($results);
        $conn = null;
        return $results;
    }

    function getUser($id){
        $conn = db_conn();
        $query = "SELECT * FROM `users` WHERE `id`= '$id'";
        try{
            $result = mysqli_query($conn, $query);
        }
        catch(Exception $e) {
            echo $e->getMessage();
        } 
        $conn = null;
        return $result;
    }

    function getUserOfEmail($email){
        $conn = db_conn();
        $query = "SELECT * FROM `users` WHERE `email`='$email'";
        try{
            $result = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $result;
    }

    function addUser($data){
        $name = $date['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $hash = $data['hash'];
        $gender = "Male";
        
        $conn = db_conn();
        $query = "INSERT INTO `users` (name, phone, email, password, gender) VALUES ('$name', '$phone', '$email', '$hash', '$gender')";
        if(mysqli_query($conn, $query)){
            $conn = null;
            return true;
        }
        $conn = null;
        return false;
    }

    function updateUser($data, $id){
        $conn = db_conn();
        $name = $data['name']; $phone=$data['phone']; $email=$data['email']; $gender=$data['gender'];
        $query = "UPDATE users SET name='$name', phone='$phone', email='$email', gender='$gender'";
        if(mysqli_query($conn, $query)){
            $conn = null;
            return true;
        }
        $conn = null;
        return false;
    }

    function deleteUser($id){
        $conn = db_conn();
        $query = "DELETE FROM users WHERE id='$id'";
        if(mysqli_query($conn, $query)){
            $conn = null;
            return true;
        }
        $conn = null;
        return false;
    }

    function getAllOperators(){
        $conn = db_conn();
        $query = "SELECT * FROM `users` WHERE `type`='operator'";
        try{
            $result = mysqli_query($conn, $query);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
        $conn = null;
        return $result;
    }

?>