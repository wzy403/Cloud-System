<?php

    require 'mysql-inc.php';    //include the data connection files
    session_start();    //start the session
    /**
     * sign an session to the user(A.K.A. login) when this php script run
     */
    if(isset($_POST['login'])){ //make suer user get in to this php script by properly click the login button
        //check does the username exist or not
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $sql = 'SELECT * FROM `users` WHERE user_uid = "'.$username.'";';
        $result_user = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result_user) <= 0 || mysqli_num_rows($result_user) > 1){
            header("Location: ../login.php?login=error");
            exit();
        }else{
            //check does the password is correct or not
            $password = mysqli_real_escape_string($conn,$_POST['password']);
            $get_info = mysqli_fetch_assoc($result_user);
            if($password !== $get_info['user_pwd']){
                header("Location: ../login.php?login=error");
                exit();
            }else{
                //Login the user(sign an session for the user)
                $_SESSION['name'] = $get_info['user_first']." ".$get_info['user_last'];
                $_SESSION['uid'] = $get_info['user_uid'];
                header("Location: ../index.php");
                exit();
            }
        }
    }else{
        header("Location: ../login.php");
        exit();
    }

?>