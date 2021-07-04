<?php
session_start();
$email = $_COOKIE["loginemail"];
$target_dir = "../pimage/";
$fname = $email . basename($_FILES["pic"]["name"]);
$target_file = $target_dir . $fname;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["upload"])) {
    $check = getimagesize($_FILES["pic"]["tmp_name"]);
    if ($check !== false) {
        echo "<h3>File is an image - " . $check["mime"] . ".</h3>";
        $uploadOk = 1;
    } else {
        header('Refresh: 2; URL=../PHP/settings.php');
        echo '<h3>File is not an image. Redirecting you to your account. Please try again.</h3>';
        $uploadOk = 0;
        $db->close();
        exit();
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    header('Refresh: 2; URL=../PHP/settings.php');
    echo '<h3>Sorry same file/picture already exists. Redirecting you to your account. Please try again with a different name.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Check file size
if ($_FILES["pic"]["size"] > 102400) {
    header('Refresh: 2; URL=../PHP/settings.php');
    echo '<h3>Sorry your file/picture is too large in size. Redirecting you to your account. Please try again with an image of size less than 100 KB.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
) {
    header('Refresh: 2; URL=../PHP/settings.php');
    echo '<h3>Sorry, only JPG, JPEG, PNG files are allowed. Redirecting you to your account. Please try again with an image of the above file extensions</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo '<h3>Sorry, your file was not uploaded.</h3>';
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
        header('Refresh: 2; URL=../PHP/settings.php');
        echo "<h3>The file " . htmlspecialchars(basename($_FILES["pic"]["name"])) . " has been uploaded.</h3><h3>Your profile picture was successfully changed, redirecting you to your account";
        echo $_FILES["pic"]["tmp_name"];
        //Deleting previous user image
        class MyDB extends SQLite3
        {
            function __construct()
            {
                $this->open('../database/test.db');
            }
        }
        $db = new MyDB();
        if (!$db) {
            header('Refresh: 2; URL=../HTML/login.html');
            echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
            exit();
        }
        $email = $_COOKIE["loginemail"];
        $sqlp = "SELECT pimage FROM customers WHERE email = '$email'";
        $retp = $db->query($sqlp);
        if (($rowp = $retp->fetchArray(SQLITE3_BOTH))) {
            $dimage = $target_dir . $rowp['pimage'];
            unlink("$dimage");
        }
        $sql = "UPDATE customers SET pimage = '$fname' WHERE email = '$email'";
        $ret = $db->exec($sql);
        if (!$ret) {
            echo "<h3>" . $db->lastErrorMsg() . "</h3>";
        } else {
            echo "<h3>Record updated successfully in database</h3>";
        }
    } else {
        echo '<h3>Sorry, there was an error uploading your file.</h3>';
    }
}
$db->close();
exit();

/*if (!move_uploaded_file($_FILES['upfile']['tmp_name'], sprintf('./uploads/%s.%s', sha1_file($_FILES['upfile']['tmp_name']), $ext))) {
    throw new RuntimeException('Failed to move uploaded file.');
}