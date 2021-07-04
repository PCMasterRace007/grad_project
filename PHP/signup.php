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
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
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
    echo '<h3>Passwords do not match, please provide same password in both fields. You will be redirected to signup page<h3>';
    exit();
} else {
    if ($len != 10) {
        $db->close();
        header('Refresh: 2; URL=../HTML/signup.html');
        echo '<h3>Incorrect number, Please signup with a correct number and do not provide country code. Redirecting to signup.</h3>';
        exit();
    } else {
        $res = $db->exec($sql);
        if (!$res) {
            header('Refresh: 2; URL=../HTML/signup.html');
            echo '<h3>' . $db->lastErrorMsg() . '</h3>';
            echo '<h3>An account with your email address or number already exists, please login or use a different email address</h3>';
        } else {
            header('Refresh: 2; URL=../HTML/login.html');
            echo '<h3>Account created. Now login with your credentials. Redirecting to login page</h3>';
        }
    }
    $db->close();
    exit();
}