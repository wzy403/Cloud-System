<?php

    require 'mysql-inc.php';    //include the data connection files
    ignore_user_abort(true);    //keep the script running when user close the page
    set_time_limit(0);  //disabled the limit of PHP script can run
    session_start();    //start the session
    
    /**
     * Upload an temp files to the server, and delete it after 10 min. (when this script run)
     */
    if (!isset($_POST['airdrop'])) {    //check does the user click the airdrop button
        header("Location: ../index.php");
        exit();
    } else {
        //get the file info upload by user
        $fileName = $_FILES['temp_upload_files']['name'];
        $fileTemp = $_FILES['temp_upload_files']['tmp_name'];
        $checkError = $_FILES['temp_upload_files']['error'];
        $fileSize = $_FILES['temp_upload_files']['size'];

        //Make sure that file did not have any error
        if ($checkError !== 0) {
            header("Location: ../index.php?upload=error");
            exit();
        } else {
            //Separate the file type and the file name, then create an uniqid name for the files and combine the type and new name together
            $fileType = end(explode('.', $fileName));
            $fileNewName = uniqid('', true) . "." . $fileType;
            $fileDestination = '../temp_storage/' . $fileNewName;   //new destination for the file

            $fileLocation = './temp_storage/' . $fileNewName;

            //create an uniqid file code that map to the file info, if the code is exist generate an another one until the code is uniqid
            $code_generate = "";
            for ($i = 0; $i < 6; $i++) {
                $code_generate = $code_generate . rand(0, 9);
            }

            $sql = 'SELECT * FROM `temp_files` WHERE code = "' . $code_generate . '"';
            $checkNoRepeatCode = mysqli_num_rows(mysqli_query($conn, $sql));
            while ($checkNoRepeatCode > 0) {
                $code_generate = "";
                for ($i = 0; $i < 6; $i++) {
                    $code_generate = $code_generate . rand(0, 9);
                }
                $sql = 'SELECT * FROM `temp_files` WHERE code = "' . $code_generate . '"';
                $checkNoRepeatCode = mysqli_num_rows(mysqli_query($conn, $sql));
            }

            //upload the file info to with the code to the database for further access
            $sql = 'INSERT INTO temp_files (code, file_name, file_location, file_size) VALUES ("' . $code_generate . '","' . $fileName . '","' . $fileLocation . '","' . $fileSize . '")';

            if (!mysqli_query($conn, $sql)) {
                header("Location: ../index.php?upload=unsuccess_database");
                exit();
            } else {
                //move the file to the temp_storage folder
                if (!move_uploaded_file($fileTemp, $fileDestination)) {
                    header("Location: ../index.php?upload=unsuccess");
                    exit();
                }else{
                    
                    header("Location: ../index.php?code=".$code_generate."");
                    
                    $_SESSION['files_code'] = $code_generate;   //create a session for the the files
                    
                    session_write_close();
                    sleep(600); //wait 10 min.
                    session_start();
                    
                    //delete the seesion and info that upload to the database and also the file that upload to the temp_storage floder
                    unset($_SESSION['files_code']);

                    $sql = 'DELETE FROM `temp_files` WHERE code = "' . $code_generate . '"';
                    if (!unlink(".".$fileLocation)) {
                        header("Location: ../index.php?del=error");
                        exit();
                    } else {
                        if (!mysqli_query($conn,$sql)) {
                            header("Location: ../index.php?del=error");
                            exit();
                        } else {
                            header("Location: ../index.php?del=succsses");
                            exit();
                        }
                    }
                }
            }
        }
    }
    exit();
