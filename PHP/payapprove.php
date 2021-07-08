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
if (!isset($_COOKIE["bloginemail"])) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3 class="txt w3-center">You are not logged in, redirecting to login</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["bloginemail"];
$bid = $_POST["bidp"];
//echo $bid . "<br>";
if (isset($_POST["pay"]) && $_POST["pay"] === "Approve pay") {
    $sql3 = "UPDATE pkg_info SET ispaid = 1 WHERE bid = '$bid'";
    //echo $sql3;
    $ret3 = $db->exec($sql3);
    header("Refresh: 0; URL=managebookings.php");
} elseif (isset($_POST["pay"]) && $_POST["pay"] === "Reject") {
    $sql3 = "UPDATE pkg_info SET iscancelled = 1 WHERE bid = '$bid'";
    //echo $sql3;
    $ret3 = $db->exec($sql3);
    header("Refresh: 0; URL=managebookings.php");
}