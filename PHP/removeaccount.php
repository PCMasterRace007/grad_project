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
    <link rel="stylesheet" href="../CSS/settings.css" />
</head>
<?php
session_start();
$adminemail = $_SESSION["adminemail"];
$adminpass = $_SESSION["adminpass"];
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('../database/test.db');
    }
}
$db = new MyDB();
if (!$db) {
    header('Refresh: 2; URL=adminlogin.php');
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
$email = $_GET["email"];
if (isset($_SESSION["adminemail"]) && isset($_SESSION["adminpass"])) {
    $sql = "DELETE FROM customers WHERE email = '$email'";
    $db->exec($sql);
    header("Refresh: 2; URL=adminpage.php?email=$adminemail&pass=$adminpass");
    echo '<h3 class="txt w3-center">' . "The customer account with email $email has been deleted" . '</h3>';
} else {
    header("Refresh: 2; URL=adminlogin.php");
    echo '<h3 class="txt w3-center">You are not logged in as an admin and therefore cannot perform this action.</h3>';
}