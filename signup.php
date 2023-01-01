<?php
    include 'includes/mysql-inc.php';   //include the data connection files
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="./css/styes.css">
</head>

<body>
    <!--form tag - Pass the user account info to the upload-user.php script by post method
        input tag (name = "Fname" & type = "text") - Take the user's First name
        input tag (name = "Sname" & type = "text") - Take the user's Last name
        input tag (name = "email" & type = "text") - Take the user's email
        input tag (name = "username" & type = "text") - Take the user's username
        input tag (name = "pwd" & type = "text") - Take the user's password
        input tag (name = "pwd" & type = "text") - Take the user's confirm password
        button tag (name = "login" & type = sumbit) - Sumbit the user account info input by user to the location that form tag pointed to-->
    <form action="./includes/upload-user.php" method="post">
        <?php
            /**
             * check does the user enter an incorrect format, if so, clear those information, only leave 
             * correct one in the input box
             */
            if(!isset($_GET['Fname'])){
                echo '<input type="text" name="Fname" id="Fname" placeholder="First name"><br>
                <input type="text" name="Sname" id="Sname" placeholder="Last name"><br>';
            }else{
                echo '<input type="text" name="Fname" id="Fname" placeholder="First name" value = "'.$_GET['Fname'].'"><br>
                <input type="text" name="Sname" id="Sname" placeholder="Last name" value = "'.$_GET['Sname'].'"><br>';
            }
            if(!isset($_GET['email'])){
                echo '<input type="email" name="email" id="email" placeholder="email"><br>';
            }else{
                echo '<input type="email" name="email" id="email" placeholder="email" value = "'.$_GET['email'].'"><br>';
            }
            if(!isset($_GET['username'])){
                echo '<input type="text" name="username" id="username" placeholder="username"><br>';
            }else{
                echo '<input type="text" name="username" id="username" placeholder="username" value = "'.$_GET['username'].'"><br>';
            }
        ?>
        <input type="password" name="pwd" id="pwd" placeholder="password">
        <input type="password" name="vpwd" id="vpwd" placeholder="confirm password">
        <br>
        <button type="submit" name = "submit" value="submit" >submit</button>
    </form>
    <?php
        /**
         * Information pass back by the upload-user.php script,
         * check does the user signup successful or not
         */
        if(isset($_GET['signup'])){
            $check = $_GET['signup'];
            if($check === "seccess"){
                echo '<script>alert("seccess signup")</script>';
            }elseif($check === "unseccsess"){
                echo '<script>alert("something went round! please signup later")</script>';
            }elseif($check === "username_error"){
                echo '<script>alert("username_taking")</script>';
            }
        }
    ?>
    <a href="./login.php">Go Login</a>
    <br>
    <a href="./index.php">Go to the home page</a>
</body>

</html>