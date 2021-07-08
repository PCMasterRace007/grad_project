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
if (!isset($_COOKIE["bloginemail"])) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3 class="txt w3-center">You are not logged in, redirecting to login</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["bloginemail"];
if (!(empty($_POST["name"]))) {
    $name = $_POST["name"];
    $sql = "UPDATE business SET name = '$name' WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("bname", $name, time() + 60 * 60 * 24 * 30);
        echo '<h3 class="txt w3-center">Changed Name</h3>';
    } else {
        echo '<h3 class="txt w3-center">Name not changed try again</h3>';
    }
}
if (!(empty($_POST["contact"]))) {
    $contact = $_POST["contact"];
    $sql = "UPDATE business SET contact = $contact WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("bcontact", $contact, time() + 60 * 60 * 24 * 30);
        echo '<h3 class="txt w3-center">Changed Contact</h3>';
    } else {
        echo '<h3 class="txt w3-center">Password not changed try again</h3>';
    }
}
if (!(empty($_POST["pass"]))) {
    $pass = $_POST["pass"];
    $sql = "UPDATE business SET pass = '$pass' WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("bloginpass", $pass, time() + 60 * 60 * 24 * 30);
        echo '<h3 class="txt w3-center">Changed Password</h3>';
    } else {
        echo '<h3 class="txt w3-center">Password not changed try again</h3>';
    }
}
$db->close();
header('Refresh: 2; URL=bsettings.php');
echo '<h3 class="txt w3-center">Redirecting you to your Business Profile</h3>';
exit();