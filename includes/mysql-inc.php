<?php
    /**
     * The database info, tack the info to connect to the database(MySQL)
     */
    $dpSever = "localhost";
    $dpUsername = "root";
    $dpPassword = "";
    $dpName = "loginsystem";

    $conn = mysqli_connect($dpSever,$dpUsername,$dpPassword,$dpName);
    
?>