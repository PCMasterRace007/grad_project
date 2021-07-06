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
$email = $_POST["email"];
$pass = $_POST["pass"];
$sql = "SELECT email, pass, name, contact FROM business WHERE email = '$email'";
//echo $sql;
$ret = $db->query($sql);
if (!($row = $ret->fetchArray(SQLITE3_BOTH))) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3>Email does not exist, please login with an existing email account or register with this email. Redirecting to login.</h3>';
    $db->close();
    exit();
} else {
    if ($row['pass'] == $pass) {
        header('Refresh: 2; URL=bsettings.php');
        setcookie("bloginemail", $email, time() + 60 * 60 * 24 * 30);
        setcookie("bloginpass", $pass, time() + 60 * 60 * 24 * 30);
        setcookie("bname", $row['name'], time() + 60 * 60 * 24 * 30);
        setcookie("bcontact", $row['contact'], time() + 60 * 60 * 24 * 30);
        echo '<h3>Login Successfull, Redirecting you to account page';
        $_SESSION["bloginemail"] = $email;
        $_SESSION["bloginpass"] = $pass;
        $_SESSION["bname"] = $row['name'];
        $_SESSION["bcontact"] = $row['contact'];
        echo $_COOKIE["bloginemail"];
        $db->close();
        exit();
    } else {
        header('Refresh: 2; URL=../HTML/blogin.html');
        echo '<h3>Login Unsuccessfull wrong password, Redirecting you to login page.';
        $db->close();
        exit();
    }
}