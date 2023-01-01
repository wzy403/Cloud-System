<?php

    require './mysql-inc.php';  //include the data connection files

    /**
     * Get the file info follow by the file code that user enter in, and pass back to the index.php page when 
     * this php script run
     */
    if(!isset($_POST['submit_code'])){  //check wherther or not user properly click the submit button or not
        header("Location: ../index.php");
    }else{
        if(!is_numeric($_POST['file_code'])){   //check is the user input is numeric or not
            header("Location: ../index.php?code=error");
            exit();
        }else{
            $fileCode = mysqli_real_escape_string($conn,$_POST['file_code']);
            if(empty($fileCode)){   //double check the fileCode, make sure it is not empty
                header("Location: ../index.php?code=empty");
                exit();
            }else{
                //using sql statement to select the files location and name that is map to the file code in the database
                $sql = 'SELECT * FROM `temp_files` WHERE code = "' . $fileCode . '"';
                $result = mysqli_query($conn, $sql);
                $checkNoRepeatCode = mysqli_num_rows($result);
                if($checkNoRepeatCode != 1){    //check does the file code exist in the database
                    header("Location: ../index.php?code=error");
                    exit();
                }else{ 
                    //get the file information and pass back to the index.php page
                    $fileInfo = mysqli_fetch_assoc($result);
                    $fileName = str_replace("&", "|", $fileInfo['file_name']);
                    header("Location: ../index.php?get_files=success&file_name=".$fileName."&file_location=".$fileInfo['file_location']."");
                    exit();
                }
            }
        }
    }
?>