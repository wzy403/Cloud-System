<?php
    require 'mysql-inc.php';    //include the data connection files
    session_start();    //start the session

    /**
     * delete all the files that user select when this php script run
     */
    if(!isset($_SESSION['uid'])){   //check wherther the user are login or not
        header("Location: ../cloud.php");
        exit();
    }else{
        if(!isset($_GET['delete'])){    //check wherther the user click the delete button or not
            header("Location: ../cloud.php?del=false");
            exit();
        }else{
            if(empty($_GET['del_files'])){  //check wherther the user select the file or not
                header("Location: ../cloud.php?del=empty");
                exit();
            }else{
                //remove all the file user select from the root and database
                $del_list = $_GET['del_files'];
                $sql = 'DELETE FROM `files` WHERE file_location = ?';
                foreach($del_list as $del){
                    $location = mysqli_real_escape_string($conn,$del);
                    $path = ".".$location;
                    if(!unlink($path)){
                        header("Location: ../cloud.php?del=empty");
                        exit();
                    }else{
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../cloud.php?del=error_prepare");
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmt,"s",$location);
                            if(!mysqli_stmt_execute($stmt)){
                                header("Location: ../cloud.php?del=error");
                                exit();
                            }else{
                                header("Location: ../cloud.php?del=succsses");
                            }
                        }
                    }
                }
                exit();
            }
        }
    }
?>