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
$email = $_POST["email"];
$pass = $_POST["pass"];
$sql = "SELECT email, pass, name, contact FROM customers WHERE email = '$email'";
$ret = $db->query($sql);
if (!($row = $ret->fetchArray(SQLITE3_BOTH))) {
    header('Refresh: 2; URL=../HTML/login.html');
    echo '<h3>Email does not exist, please login with an existing email account or register with this email. Redirecting to login.</h3>';
    $db->close();
    exit();
} else {
    if ($row['pass'] == $pass) {
        header('Refresh: 2; URL=account.php');
        setcookie("loginemail", $email, time() + 60 * 60 * 24 * 30);
        setcookie("loginpass", $pass, time() + 60 * 60 * 24 * 30);
        setcookie("name", $row['name'], time() + 60 * 60 * 24 * 30);
        setcookie("contact", $row['contact'], time() + 60 * 60 * 24 * 30);
        echo '<h3>Login Successfull, Redirecting you to account page';
        $_SESSION["loginemail"] = $email;
        $_SESSION["loginpass"] = $pass;
        $_SESSION["name"] = $row['name'];
        $_SESSION["contact"] = $row['contact'];
        echo $_COOKIE["loginemail"];
        $db->close();
        exit();
    } else {
        header('Refresh: 2; URL=../HTML/login.html');
        echo '<h3>Login Unsuccessfull wrong password, Redirecting you to login page.';
        $db->close();
        exit();
    }
}