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
    header('Refresh: 2; URL=../HTML/index.html');
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
if (isset($_COOKIE["loginemail"]) && isset($_COOKIE["loginpass"])) {
    $email = $_COOKIE["loginemail"];
    $pass = $_COOKIE["loginpass"];
    $sql = "SELECT email, pass, name FROM customers WHERE email = '$email' AND pass = '$pass'";
    $ret = $db->query($sql);
    if ($row = $ret->fetchArray(SQLITE3_BOTH)) {
        header('Refresh: 2; URL=account.php');
        $name = $row['name'];
        setcookie("name", $row['name'], time() + 60 * 60 * 24 * 30);
        echo "<h3>Welcome $name, redirecting you to home.</h3>";
    }
} else {
    header('Refresh: 1; URL=../HTML/index.html');
}