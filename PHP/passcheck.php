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
$pass = $_POST["pass"];
$email = $_COOKIE["loginemail"];
$sql = "SELECT pass FROM customers WHERE email = '$email'";
$ret = $db->query($sql);
if ($row = $ret->fetchArray(SQLITE3_BOTH)) {
    if($row['pass']==$pass){
        header('Refresh: 2; URL=accedit.php');
        echo "<h3>Password check successful, redirecting to edit page.</h3>";  
    }
    else {
        header('Refresh: 2; URL=settings.php');
        echo "<h3>Password check not successful, returning to profile page.</h3>";
    }
}
else{
    header('Refresh: 2; logout.php');
    echo "<h3>ERROR</h3>"; 
}
$db->close();