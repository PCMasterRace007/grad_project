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
if (!isset($_COOKIE["loginemail"])) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3 class="txt w3-center">You are not logged in, redirecting to login</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["bloginemail"];
$bid = $_POST["bid"];
$target_dir = "../payimage/";
$fname = $bid . "." . strtolower(pathinfo($_FILES["proof"]["name"], PATHINFO_EXTENSION));
$target_file = $target_dir . $fname;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["upload"])) {
    $check = getimagesize($_FILES["proof"]["tmp_name"]);
    if ($check !== false) {
        echo '<h3 class="txt w3-center">File is an image - ' . $check["mime"] . ".</h3>";
        $uploadOk = 1;
    } else {
        header("Refresh: 2; URL=showbooking.php?bid=$bid");
        echo '<h3 class="txt w3-center">File is not an image. Redirecting you to your account. Please try again.</h3>';
        $uploadOk = 0;
        $db->close();
        exit();
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class="txt w3-center">Sorry same file/picture already exists. Redirecting you to your account. Please try again with a different name.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Check file size
if ($_FILES["proof"]["size"] > 1048576) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class="txt w3-center">Sorry your file/picture is too large in size. Redirecting you to your account. Please try again with an image of size less than 1 MB.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class="txt w3-center">Sorry, only JPG, JPEG, PNG files are allowed. Redirecting you to your account. Please try again with an image of the above file extensions</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo '<h3 class="txt w3-center">Sorry, your file was not uploaded.</h3>';
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
        header("Refresh: 2; URL=showbooking.php?bid=$bid");
        echo '<h3 class="txt w3-center">The file ' . htmlspecialchars(basename($_FILES["proof"]["name"])) . " as payment proof has been uploaded.</h3>";
    } else {
        header("Refresh: 2; URL=showbooking.php?bid=$bid");
        echo '<h3 class="txt w3-center">Sorry, there was an error uploading your file. Try again.</h3>';
    }
}
$db->close();
exit();