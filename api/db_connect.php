<?php

    function db_conn(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "etickets";

        try{
            $conn = mysqli_connect($servername, $username, $password, $dbname);
        }
        catch(Exception $e){
            echo $e -> getMessage();
        }
        return $conn;
    }

?>