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
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
if (!isset($_COOKIE["loginemail"])) {
    header('Refresh: 2; URL=../HTML/login.html');
    echo '<h3 class="w3-center txt">You are not logged in, please login. Redirecting you to login page</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["loginemail"];
$bid = $_GET["bid"];
$sql = "UPDATE pkg_info SET iscancelled = 1 WHERE bid ='$bid'";
$ret = $db->exec($sql);
if (!$ret) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class="w3-center txt">There was some error try again</h3>';
    //echo $sql;
} else {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3 class="w3-center txt">The package was cancelled</h3>';
    //echo $sql;
}