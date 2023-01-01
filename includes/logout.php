<?php
    session_start();    //start the session
    /**
     * logout the user when this PHP script run
     */
    if(!isset($_SESSION['name'])){  //check does the user login when this script run
        header("Location: ../index.php");
        exit();
    }else{
        //destroy the user session
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
?>