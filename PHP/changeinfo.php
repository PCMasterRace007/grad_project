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
$email = $_COOKIE["loginemail"];
if (!(empty($_POST["name"]))) {
    $name = $_POST["name"];
    $sql = "UPDATE customers SET name = '$name' WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("name", $name, time() + 60 * 60 * 24 * 30);
        echo "<h3>Changed Name</h3>";
    } else {
        echo "<h3>Name not changed try again</h3>";
    }
}
if (!(empty($_POST["contact"]))) {
    $contact = $_POST["contact"];
    $sql = "UPDATE customers SET contact = $contact WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("contact", $contact, time() + 60 * 60 * 24 * 30);
        echo "<h3>Changed Contact</h3>";
    } else {
        echo "<h3>Password not changed try again</h3>";
    }
}
if (!(empty($_POST["pass"]))) {
    $pass = $_POST["pass"];
    $sql = "UPDATE customers SET pass = '$pass' WHERE email = '$email'";
    $ret = $db->exec($sql);
    if ($ret) {
        setcookie("loginpass", $pass, time() + 60 * 60 * 24 * 30);
        echo "<h3>Changed Password</h3>";
    } else {
        echo "<h3>Password not changed try again</h3>";
    }
}
$db->close();
header('Refresh: 2; URL=settings.php');
echo "<h3>Redirecting you to your Profile</h3>";
exit();