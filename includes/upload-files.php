<?php
    require 'mysql-inc.php';    //include the data connection files
    ignore_user_abort(true);    //keep the script running when user close the page
    set_time_limit(0);  //disabled the limit of PHP script can run
    session_start();    //start the session
    /**
     * Take the files that selcet by the user and upload to the server when this PHP script run
     */
    if(isset($_SESSION['uid'])){    //check if user logged in
        
        if(!isset($_POST['upload_file_botton'])){   //check is user clicked the upload button
            header("Location: ../cloud.php");
            exit();
        }else{
            //get the info of the files that user upload
            $fileName = $_FILES['fileupload']['name'];
            $fileTemp = $_FILES['fileupload']['tmp_name'];
            $checkError = $_FILES['fileupload']['error'];
            $fileSize = $_FILES['fileupload']['size'];
            
            //Make sure that file did not have any error
            if($checkError !== 0){
                header("Location: ../cloud.php?upload=error");
                exit();
            }else{
                //Separate the file type and the file name, then create an uniqid name for the files and combine the type and new name together
                $fileType = end(explode('.',$fileName));
                $fileNewName = uniqid('', true).".".$fileType;
                $fileDestination = '../storage/'.$fileNewName;  //new destination for the file

                $fileLocation = './storage/'.$fileNewName;
                $username = mysqli_real_escape_string($conn,$_SESSION['uid']);
                
                //Insert the file info to the database for further access
                $sql = 'INSERT INTO files (username, file_name, file_location, upload_time, file_size) VALUES ("'.$username.'", "'.$fileName.'", "'.$fileLocation.'", "'.date("Y-m-d").' '.date("H:i:s").'", "'.$fileSize.'");';
                if(!mysqli_query($conn,$sql)){
                    header("Location: ../cloud.php?upload=unsuccess_database");
                    exit();
                }else{
                    //move the file from temp location to the file destination
                    if(!move_uploaded_file($fileTemp,$fileDestination)){
                        header("Location: ../cloud.php?upload=unsuccess");
                        exit();
                    }else{
                        header("Location: ../cloud.php?upload=success");
                        exit();
                    }
                }
            }
        }
    }else{
        header("Location: ../cloud.php");
        exit();
    }
    exit();
