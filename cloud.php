<?php
    include_once './includes/mysql-inc.php';    //include the data connection files
    session_start();    //start the session
    //check does the user login or not
    if (!isset($_SESSION['uid'])) {
        header("Location: ./index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My cloud</title>
    <link rel="stylesheet" href="./css/cloud_styes.css">
</head>

<body>
    <!--form tag - Pass the file info input by user into upload-files.php script by post method
        input tag (name = fileupload & type = file) - Take the info of the file select by the user
        button tag (name = upload_file_botton & type = sumbit) - Sumbit the file info to the location that form tag pointed to-->
    <form action="./includes/upload-files.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileupload" id="fileupload">
        <button type="submit" name="upload_file_botton">Upload</button>
    </form>

    <h1>My Cloud</h1>
    <!--form tag - Pass the file info input by user into del-files.php script by get method
        button tag (name = delete & type = sumbit) - Sumbit the delete file info to the the location that form tag pinted to
        table tage - use to display any files that logged in user stored in database-->
    <form action="./includes/del-files.php" method="get">
        <button type="submit" name="delete">Delete Files</button>
        <table border="1">
            <div>
                <th>Select</th>
                <th>Files Name</th>
                <th>Upload Date</th>
                <th>Size</th>
                <th>Download Files</th>
            </div>
            <?php
            /**
             * display the files that user has stored in the database
             */
            if (isset($_SESSION['uid'])) {
                $username = mysqli_real_escape_string($conn, $_SESSION['uid']);
                $sql = 'SELECT * FROM files WHERE username = "' . $username . '";';
                $result = mysqli_query($conn, $sql);
                $index = 0;
                while ($temp = mysqli_fetch_assoc($result)) {
                    echo "<tr class = 'cloud_select'>";
                    echo "<td><input type='checkbox' name='del_files[]' value='" . $temp['file_location'] . "'></td>";
                    echo "<td id = 'file_name'>" . $temp['file_name'] . "</td>";
                    echo "<td>" . $temp['upload_time'] . "</td>";
                    echo "<td>" . $temp['file_size'] . "kb</td>";
                    echo "<td><a href='" . $temp['file_location'] . "' download = '" . $temp['file_name'] . "'>Download</a></td>";
                    echo "<td><button type = 'button' name = 'rename' id = 'rename" . $index . "' value = '" . $temp['id'] . "|" . $temp['file_name'] . "'>RENAME</button></td>";
                    echo "</tr>";
                    $index++;
                }
            }
            ?>
        </table>
    </form>
    
    <!-- script written by JavaScript, the script is will continues check when user click the rename button, when user clicked the rename button, the script pass the value that stored in the rename button to the rename_files.php by get method -->
    <script>
        var buttonList = document.getElementsByName("rename");
        for (var index = 0; index < buttonList.length; index++) {
            buttonList[index].onclick = function() {
                let tempName = prompt("enter an new name: ");
                if (tempName != null && tempName != "") {
                    var info = document.getElementById(this.id).value;
                    var infoList = info.split('|');
                    var oldName = infoList[infoList.length - 1].replace(/&/g, '|');

                    window.location.href = "includes/rename_files.php?send_by_js=true&id=" + infoList[0] + "&old_name=" + oldName + "&new_name=" + tempName;

                }
            }
        }
    </script>
    <a href="./index.php">Back to home page</a>
</body>

</html>