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
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
$email = $_COOKIE["bloginemail"];
if (!(empty($_POST["name"]))) {
    $name = $_POST["name"];
    $sql = "UPDATE business SET name = '$name' WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("bname", $name, time() + 60 * 60 * 24 * 30);
        echo "<h3>Changed Name</h3>";
    } else {
        echo "<h3>Name not changed try again</h3>";
    }
}
if (!(empty($_POST["contact"]))) {
    $contact = $_POST["contact"];
    $sql = "UPDATE business SET contact = $contact WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("bcontact", $contact, time() + 60 * 60 * 24 * 30);
        echo "<h3>Changed Contact</h3>";
    } else {
        echo "<h3>Password not changed try again</h3>";
    }
}
if (!(empty($_POST["pass"]))) {
    $pass = $_POST["pass"];
    $sql = "UPDATE business SET pass = '$pass' WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("bloginpass", $pass, time() + 60 * 60 * 24 * 30);
        echo "<h3>Changed Password</h3>";
    } else {
        echo "<h3>Password not changed try again</h3>";
    }
}
$db->close();
header('Refresh: 2; URL=bsettings.php');
echo "<h3>Redirecting you to your Business Profile</h3>";
exit();