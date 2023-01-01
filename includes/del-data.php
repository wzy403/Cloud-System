<?php
    include 'mysql-inc.php'; //include the data connection files

    
    /**
     * when this script run, it will get the remove the user account from the database;
     */

    //Check if the user actially click the submit button
    if(isset($_POST['remove'])){
        //Check if user actually input anything in to the input box
        //If the user did not input anythin it will return to the signup page
        //else it will keep run the scrip below
        if(!isset($_POST['removeID'])){
            header("Location: ../signup.php?remove=unseccss");
            exit();
        }else{

            //start parper the MySQL statement
            $remove = mysqli_real_escape_string($conn,$_POST['removeID']);

            $sql = "DELETE FROM users WHERE user_id=?";
            $statement = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($statement,$sql)){
                header("Location: ../signup.php?remove=unseccss");
            }else{
                mysqli_stmt_bind_param($statement,"i",$remove);
                
                //execute the sql statement
                if(!mysqli_stmt_execute($statement)){
                    header("Location: ../signup.php?remove=unseccss");
                    exit();
                }else{
                    header("Location: ../signup.php?remove=seccss");
                    exit();
                }
            }
        }
    }else{
        header("Location: ../signup.php");
        exit();
    }
?>