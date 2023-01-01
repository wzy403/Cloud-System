<?php
    include 'mysql-inc.php';    //include the data connection files

    /**
     * Upload the user account info to the database when this PHP script is run
     */
    if(!isset($_POST['submit'])){   //checking if user click the signup the botton or not
        header("Location: ../signup.php");
        exit();
    }else{
        //get the info enter by user
        $fn = mysqli_real_escape_string($conn,$_POST['Fname']);
        $ln = mysqli_real_escape_string($conn,$_POST['Sname']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
        $vpwd = mysqli_real_escape_string($conn,$_POST['vpwd']);

        //check does user miss/forget to input on one or more input box
        if(empty($fn) || empty($ln) || empty($email) || empty($username) || empty($pwd)){
            header("Location: ../signup.php?signup=empty&Fname=$fn&Sname=$ln&email=$email&username=$username");
            exit();
        }else{
            //check does the first name and last name input by the user is in letter
            if(!preg_match("/^[a-zA-Z]*$/",$fn) || !preg_match("/^[a-zA-Z]*$/",$ln)){
                header("Location: ../signup.php?signup=error&email=$email&username=$username");
                exit();
            }else{
                //check does the email input by user is is the correct format according to the email format
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    header("Location: ../signup.php?signup=error&Fname=$fn&Sname=$ln&username=$username");
                    exit();
                }else{
                    //check does the username enter by the user is been taking or not 
                    $sql = 'SELECT * FROM `users` WHERE user_uid = "'.$username.'";';
                    $result = mysqli_query($conn,$sql);
                    $resultCheck = mysqli_num_rows($result);
                    if($resultCheck > 0){
                        header("Location: ../signup.php?signup=username_error&Fname=$fn&Sname=$ln&email=$email");
                        exit();
                    }else{
                        //check does the password and confirm password input by user is same or not
                        if($pwd !== $vpwd){
                            header("Location: ../signup.php?signup=error&Fname=$fn&Sname=$ln&email=$email&username=$username");
                            exit();
                        }else{
                            //prepare the sql statement
                            $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES (?,?,?,?,?);";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../signup.php?signup=unseccsess");
                                exit();
                            }else{
                                mysqli_stmt_bind_param($stmt,"sssss",$fn,$ln,$email,$username,$pwd);
                                //execute the sql statement
                                if(!mysqli_stmt_execute($stmt)){
                                    header("Location: ../signup.php?signup=unseccsess");
                                    exit();
                                }else{
                                    header("Location: ../signup.php?signup=seccess");
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
