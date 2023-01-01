<?php
    require 'mysql-inc.php';    //include the data connection files
    session_start();    //start the session
    /**
     * That the info send by js script to rename the files name when this PHP script run
     */
    if(!isset($_SESSION['uid'])){   //check does the user this login or not
        header("Location: ../cloud.php");
        exit();
    }else{
        if(!isset($_GET['send_by_js'])){    //check does the user click the rename button or not
            header("Location: ../cloud.php?rename=error");
            exit();
        }else{
            //Get the info that send by js
            $fileID = mysqli_real_escape_string($conn,$_GET['id']);
            $oldName = str_replace("|", "&", mysqli_real_escape_string($conn,$_GET['old_name']));
            $newName = mysqli_real_escape_string($conn,$_GET['new_name']);
            $username = mysqli_real_escape_string($conn,$_SESSION['uid']);

            $typeName = end(explode('.',$oldName));

            //using sql statement to update new info(new file name) to the database
            $sql = "UPDATE files SET file_name='".$newName.".".$typeName."' WHERE id=".$fileID." AND username ='".$username."';";
            if(!mysqli_query($conn,$sql)){
                header("Location: ../cloud.php?rename=sql_fail");
                exit();
            }else{
                //check does the rename process successfully changing the files name
                $sql = 'SELECT * FROM `files` WHERE id='.$fileID;
                $result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
                if($result['file_name'] === $oldName){
                    header("Location: ../cloud.php?rename=error");
                    exit();
                }else{
                    header("Location: ../cloud.php?rename=succsess");
                    exit();
                }
            }
        }
    }
?>