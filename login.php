<?php
    session_start();    //start the session
    if(isset($_SESSION['name'])){   //check does the user already login or not
        header("Location: ./index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <!--form tag - Pass the user login info to the login-user.php script by post method
        input tag (name = "username" & type = "text") - Takes the username input by user
        input tag (name = "password" & type = "text") - Takes the password input by user
        button tag (name = "login" & type = sumbit) - Sumbit the username and password input by user to the location that form tag pointed to-->
    <form action="./includes/login-user.php" method="post">
        <label for="username">username</label>
        <br>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">password</label>
        <br>
        <input type="password" name="password" id="password">
        <br>
        <button type="submit" name = "login">LOGIN</button>
    </form>

    <a href="./signup.php">Go signup</a>
    <br>
    <a href="./index.php">Back to Home</a>
</body>
</html>