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
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3 class="txt w3-center">Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
if (!isset($_COOKIE["loginemail"])) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3 class="txt w3-center">You are not logged in, redirecting to login</h3>';
    $db->close();
    exit();
}
$pass = $_POST["pass"];
$email = $_COOKIE["bloginemail"];
$sql = "SELECT pass FROM business WHERE email = '$email'";
$ret = $db->query($sql);
if ($row = $ret->fetchArray(SQLITE3_BOTH)) {
    if ($row['pass'] == $pass) {
        header('Refresh: 2; URL=baccedit.php');
        echo '<h3 class="txt w3-center">Password check successful, redirecting to edit page.</h3>';
    } else {
        header('Refresh: 2; URL=bsettings.php');
        echo '<h3 class="txt w3-center">Password check not successful, returning to profile page.</h3>';
    }
} else {
    header('Refresh: 2; blogout.php');
    echo '<h3 class="txt w3-center">ERROR</h3>';
}
$db->close();