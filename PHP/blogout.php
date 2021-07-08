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
setcookie("bloginemail", "", 1);
setcookie("bloginpass", "", 1);
setcookie("bname", "", 1);
setcookie("bcontact", "", 1);
unset($_SESSION["bloginemail"]);
unset($_SESSION["bloginpass"]);
unset($_SESSION["bname"]);
unset($_SESSION["bcontact"]);
header('Refresh: 2; URL=../HTML/business.html');
echo '<h3 class="w3-center txt">Logging out, redirecting to home page.</h3>';