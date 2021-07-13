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
$email = $_POST["email"];
$pass = $_POST["pass"];
$sql = "SELECT email, pass, name, contact FROM business WHERE email = '$email'";
//echo $sql;
$ret = $db->query($sql);
if (!($row = $ret->fetchArray(SQLITE3_BOTH))) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3 class="txt w3-center">Email does not exist, please login with an existing email account or register with this email. Redirecting to login.</h3>';
    $db->close();
    exit();
} else {
    if ($row['pass'] == $pass) {
        header('Refresh: 2; URL=bsettings.php');
        setcookie("bloginemail", $email, time() + 60 * 60 * 24 * 30);
        setcookie("bloginpass", $pass, time() + 60 * 60 * 24 * 30);
        setcookie("bname", $row['name'], time() + 60 * 60 * 24 * 30);
        setcookie("bcontact", $row['contact'], time() + 60 * 60 * 24 * 30);
        echo '<h3 class="txt w3-center">Login Successfull, Redirecting you to account page';
        $_SESSION["bloginemail"] = $email;
        $_SESSION["bloginpass"] = $pass;
        $_SESSION["bname"] = $row['name'];
        $_SESSION["bcontact"] = $row['contact'];
        //echo $_COOKIE["bloginemail"];
        $db->close();
        exit();
    } else {
        header('Refresh: 2; URL=../HTML/blogin.html');
        echo '<h3 class="txt w3-center">Login Unsuccessfull wrong password, Redirecting you to login page.';
        $db->close();
        exit();
    }
}