<?php
    include_once 'includes/mysql-inc.php';  //include the data connection files
    session_start();    //start the session
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
</head>

<body>
    <?php
    /**
     * check does the user login or not, if user login, display the portal to the storage/cloud page
     */
    if (!isset($_SESSION['name'])) {
        echo '<a href="./login.php">login</a><br><a href="./signup.php">signup</a>';
    } else {
        echo '<p id = "name">welcome back <b>' . $_SESSION['name'] . '</b>!</p>';
        // echo '<br>';
        echo '<form action="./includes/logout.php" method="post"><button type="submit" name = "logout">logout</button></form>';
        echo '<a href="./cloud.php">storage</a>';
    }
    ?>
    <br>
    <br>
    <h2>AirDrop</h2>
    <!--form tage (name = "temp_files") - collect the file info when user input it by temp_upload_files input tag
        input tag (name = "temp_upload_files" & type = "file") - Take the info of the file select by the user
        button tag (name = "airdrop") - A button that mapping to the script below-->
    <form method="post" enctype="multipart/form-data" name="temp_files">
        <input type="file" name="temp_upload_files" id="fileupload">
        <button type="submit" name="airdrop">AirDrop</button>
    </form>
    
    <script>
        //copy from https://developer.mozilla.org/zh-CN/docs/Web/API/FormData/Using_FormData_Objects
        //modified a little and this script is using javascript to pass info to the upload-temp_files.php script by post method
        //The script will keep listen to the button name "airdrop" when the button been clicked, it will seed every thing to the upload-temp_files.php
        var form = document.forms.namedItem("temp_files");
        form.addEventListener('submit', function(ev) {

            var formData = new FormData(form);

            formData.append("airdrop", "yes");
            formData.append("temp_upload_files", fileupload.files[0]);

            var oReq = new XMLHttpRequest();
            oReq.open("POST", "./includes/upload-temp_files.php", true);

            alert("The file has being uploaded, \n\nPlease click the Get File Code button to get the file code!");
            document.getElementById("reload_label").innerHTML="click the button to get the code!";

            oReq.send(formData);
            ev.preventDefault();
        }, false);

    </script>

    <!-- button tag (name = "reload_code") - when the button being clicked, run the script that it map to -->
    <button name = "reload_code", id = "reload_code" onclick="refreshPage();">Get File Code</button>
    <label for="reload_code" name = "reload_label" id = "reload_label">click the button to get the code!</label>
    <script>
        function refreshPage() {    //refresh the page
            window.location.href = "./index.php?get_code=true";
        }
    </script>

    <?php
    /**
     * check does the user click the "reload_code" button and dose user upload any file to the server, if upload 
     * the file code will be display on the screen
     */
    if(isset($_GET['get_code']) && !isset($_SESSION['files_code'])){
        echo '<script>document.getElementById("reload_label").innerHTML="no file is being upload, please upload the file first before getting the code!"</script>';
    }elseif (!isset($_GET['get_code']) && !isset($_SESSION['files_code'])) {
        echo '<script>document.getElementById("reload_label").innerHTML="click the button to get the code!"</script>';
    }else{
        if (isset($_GET['get_code'])) {
            echo '<script>alert("file code: ' . $_SESSION['files_code'] . ' (Expire in 10 min.)")</script>';
            echo '<script>window.location.href = "./index.php";</script>';
        }
        echo '<script>document.getElementById("reload_label").innerHTML="file code: ' . $_SESSION['files_code'] . ' (Expire in 10 min.)"</script>';
    }
    ?>
    <br>
    <br>
    <!--form tag - Pass the file code info input by user to the get-temp_files.php script by post method
        input tag (name = "file_code" & type = "number") - Takes the file code input by user
        button tag (name = "submit_code" & type = sumbit) - Sumbit the file code to the location that form tag pointed to-->
    <form action="./includes/get-temp_files.php" method="post">
        <input type="number" name="file_code" id="file_code" placeholder="Enter an 6-dig file code">
        <button type="submit" name="submit_code">GET FILES</button>
    </form>

    <?php
    /**
     * Get the file info that pass back by get-temp_files.php script and display on the web page
     */
    if (isset($_GET['get_files'])) {    //check does the get-temp_files.php script pass any back
        $file_name = str_replace("|", "&", $_GET['file_name']);
        $file_location = $_GET['file_location'];

        echo "<h3>AirDrop files</h3>";
        echo "<ul>";
        echo "<li><a href='" . $file_location . "' download = '" . $file_name . "'>" . $file_name . "</a></li>";
        echo "</ul>";
    }
    ?>

</body>

</html>