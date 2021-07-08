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
    echo '<h3 class="w3-center txt">Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
if (!isset($_COOKIE["bloginemail"])) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3 class="w3-center txt">You are not logged in, redirecting to login</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["bloginemail"];
$pass = $_POST["passc"];
$accno = $_POST["accno"];
$ifsc = $_POST["ifsc"];
if (strlen($ifsc) < 11 || strlen($ifsc) < 11) {
    header('Refresh: 2; URL=bsettings.php');
    echo '<h3 class="txt w3-center">Enter correct IFSC number which is precisely 11 digits. Redirecting you to account page.</h3>';
    $db->close();
    exit();
}
$sql = "SELECT pass, accno, ifsc FROM business WHERE email = '$email'";
$ret = $db->query($sql);
if (!($row = $ret->fetchArray(SQLITE3_BOTH))) {
    header('Refresh: 2; URL=blogout.php');
    echo '<h3 class="txt w3-center">Error encountered, logging out. Please relogin.</h3>';
    $db->close();
    exit();
} else {
    if ($pass == $row['pass']) {
        echo '<h3 class="txt w3-center">Password confirmed.</h3>';
        $sql2  = "UPDATE business SET accno = '$accno', ifsc = '$ifsc' WHERE email = '$email'";
        $ret2 = $db->exec($sql2);
        if (!$ret) {
            header('Refresh: 2; URL=bsettings.php');
            echo '<h3 class="txt w3-center">Failed to changed password. Try again.</h3>';
            $db->close();
            exit();
        } else {
            header('Refresh: 2; URL=bsettings.php');
            echo '<h3 class="txt w3-center">Account number and IFSC added to your account. Redirecting you to your account</h3>';
            $db->close();
            exit();
        }
    } else {
        header('Refresh: 2; URL=bsettings.php');
        echo '<h3 class="txt w3-center">Password did not match. Try again. Redirecting to your account</h3>';
        $db->close();
        exit();
    }
}
?>