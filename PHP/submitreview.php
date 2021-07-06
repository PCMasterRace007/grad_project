<!DOCTYPE html>
<html lang="en">

<head>
    <title>indiXplore, let's travel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/3bd38c0192.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="../android-chrome-512x512.png" />
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/settings.css" />
</head>
<?php
session_start();
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
    echo '<h3 class = "txt w3-center">Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
if (!isset($_COOKIE["loginemail"])) {
    header('Refresh: 2; URL=../HTML/login.html');
    echo '<h3 class="w3-center txt">You are not logged in, please login. Redirecting you to login page</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["loginemail"];
$rating = $_POST["rating"];
$review = $_POST["review"];
$bid = $_POST["bid"];
$pid = $_POST["pid"];
$target_dir = "../rimage/";
$fname = $bid . "." . strtolower(pathinfo($_FILES["rimage"]["name"], PATHINFO_EXTENSION));
//echo $fname;
$target_file = $target_dir . $fname;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["upload"])) {
    $check = getimagesize($_FILES["rimage"]["tmp_name"]);
    if ($check !== false) {
        echo "<h3>File is an image - " . $check["mime"] . ".</h3>";
        $uploadOk = 1;
    } else {
        header("Refresh: 2; URL=showbooking.php?bid=$bid");
        echo '<h3 class = "txt w3-center">File is not an image. Redirecting you to your account. Please try again.</h3>';
        $uploadOk = 0;
        $db->close();
        exit();
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class = "txt w3-center">Sorry same file/picture already exists. Redirecting you to your account. Please try again with a different name.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Check file size
if ($_FILES["rimage"]["size"] > 1048576) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class = "txt w3-center">Sorry your file/picture is too large in size. Redirecting you to your account. Please try again with an image of size less than 1 MB.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class = "txt w3-center">Sorry, only JPG, JPEG, PNG files are allowed. Redirecting you to your account. Please try again with an image of the above file extensions</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

if ($uploadOk == 0) {
    echo '<h3 class = "txt w3-center>Sorry, your file was not uploaded.</h3>';
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["rimage"]["tmp_name"], $target_file)) {
        echo "<h3" . ' class = "txt w3-center"' . ">The file " . htmlspecialchars(basename($_FILES["proof"]["name"])) . " has been uploaded.</h3>" . '<h3 class = "txt w3-center">Your profile picture was successfully changed, redirecting you to your account';
        $sql = "INSERT INTO review (
            email,
            pid,
            bid,
            rimage,
            description,
            rating
        )
        VALUES (
            '$email',
            '$pid',
            '$bid',
            '$fname',
            '$review',
            '$rating'
        )";
        $ret = $db->exec($sql);
        if (!$ret) {
            header("Refresh: 2; URL=showbooking.php?bid=$bid");
            echo '<h3 class = "txt w3-center">Sorry, there was an error while uploading your review. Try again.</h3>';
        } else {
            header("Refresh: 2; URL=showbooking.php?bid=$bid");
            echo '<h3 class = "txt w3-center">Review added successfully.</h3>';
        }
    } else {
        header("Refresh: 2; URL=showbooking.php?bid=$bid");
        $sql = "DELETE FROM review WHERE bid = '$bid'";
        $ret = $db->exec($sql);
        echo '<h3 class = "txt w3-center">Sorry, there was an error uploading your file.</h3>';
    }
}
$db->close();
exit();