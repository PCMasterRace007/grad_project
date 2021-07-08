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
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('../database/test.db');
    }
}
$db = new MyDB();
if (!$db) {
    header('Refresh: 2; URL=../HTML/signup.html');
    echo '<h3 class="txt w3-center">Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
$name = $_POST["name"];
$email = $_POST["email"];
$pass = $_POST["pass"];
$passconfirm = $_POST["passconfirm"];
$contact = $_POST["contact"];
$len = strlen((string)$contact);
$sql =  "INSERT INTO customers
(email, pass, name, contact)
VALUES('$email', '$pass', '$name', $contact);";

if ($pass != $passconfirm) {
    $db->close();
    header('Refresh: 2; URL=../HTML/signup.html');
    echo '<h3 class="txt w3-center">Passwords do not match, please provide same password in both fields. You will be redirected to signup page<h3>';
    exit();
} else {
    if ($len != 10) {
        $db->close();
        header('Refresh: 2; URL=../HTML/signup.html');
        echo '<h3 class="txt w3-center">Incorrect number, Please signup with a correct number and do not provide country code. Redirecting to signup.</h3>';
        exit();
    } else {
        $res = $db->exec($sql);
        if (!$res) {
            header('Refresh: 2; URL=../HTML/signup.html');
            echo '<h3 class="txt w3-center">' . $db->lastErrorMsg() . '</h3>';
            echo '<h3 class="txt w3-center">An account with your email address or number already exists, please login or use a different email address</h3>';
        } else {
            header('Refresh: 2; URL=../HTML/login.html');
            echo '<h3 class="txt w3-center">Account created. Now login with your credentials. Redirecting to login page</h3>';
        }
    }
    $db->close();
    exit();
}