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
    header('Refresh: 2; URL=adminlogin.php');
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
$email = $_GET["email"];
$pass = $_GET["pass"];
$sql = "SELECT email, pass, name FROM admin WHERE email = '$email'";
$ret = $db->query($sql);
if (!($row = $ret->fetchArray(SQLITE3_BOTH))) {
    header('Refresh: 2; URL=adminlogin.php');
    echo '<h3 class="txt w3-center">Email does not exist, please login with an existing email account or register with this email. Redirecting to login.</h3>';
    $db->close();
    exit();
} else {
    if ($row['pass'] !== $pass) {
        header('Refresh: 2; URL=adminlogin.php');
        echo '<h3 class="txt w3-center">Admin credentials invalid';
        $db->close();
        exit();
    } else {
        echo '<h3 class="txt w3-center">Login successfull, Welcome ' . ucwords($row['name']) . '</h3>';
        $_SESSION["adminemail"] = $email;
        $_SESSION["adminpass"] = $pass;
    }
}
?>
<?php
$sql2 = "SELECT email, name, contact FROM business";
$ret2 = $db->query($sql2);
$sql3 = "SELECT pid, name, cost, bemail FROM packages";
$ret3 = $db->query(($sql3));
$sql4 = "SELECT contact, name, email FROM customers";
$ret4 = $db->query(($sql4));
?>

<body>
    <div class="w3-container txt">
        <h4 class="w3-center txt">Manage site</h4>
        <h5 class="w3-center txt">You can view business and packages and customers and remove them.</h5>
    </div>
    <div class="w3-container">

    </div>
    <div class="w3-container">
        <div class="w3-bar w3-bc">
            <button class="w3-bar-item w3-center w3-button tablink w3-fc"
                onclick="openTab(event, 'Business')">Business</button>
            <button class="w3-bar-item w3-center w3-button tablink"
                onclick="openTab(event, 'Packages')">Packages</button>
            <button class="w3-bar-item w3-center w3-button tablink"
                onclick="openTab(event, 'Customers')">Customers</button>
        </div>
    </div>
    <div id="Business" class="w3-container tab">
        <div class="w3-responsive">
            <table class="w3-table-all txt">
                <tr class="w3-fc txtb">
                    <th>
                        Business Name
                    </th>
                    <th>
                        Business Email
                    </th>
                    <th>
                        Business Contact
                    </th>
                    <th>
                        Remove Business
                    </th>
                </tr>
                <?php while ($row2 = $ret2->fetchArray(SQLITE3_BOTH)) { ?>
                <tr class="txt">
                    <td>
                        <?php echo ucwords($row2['name']) ?>
                    </td>
                    <td>
                        <?php echo $row2['email'] ?>
                    </td>
                    <td>
                        <?php echo $row2['contact'] ?>
                    </td>
                    <td>
                        <a href="removebaccount.php?email=<?php echo $row2['email']; ?>"><button
                                class="w3-button txt w3-red w3-center">Remove Business</button></a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div id="Packages" class="w3-container tab" style="display:none">
        <div class="w3-responsive">
            <table class="w3-table-all txt">
                <tr class="w3-fc txtb">
                    <th>
                        Package Name
                    </th>
                    <th>
                        Package ID
                    </th>
                    <th>
                        Package Cost
                    </th>
                    <th>
                        Business Linked Email
                    </th>
                    <th>
                        Remove Package
                    </th>
                </tr>
                <?php while ($row3 = $ret3->fetchArray(SQLITE3_BOTH)) { ?>
                <tr class="txt">
                    <td>
                        <?php echo ucwords($row3['name']) ?>
                    </td>
                    <td>
                        <a href="searchdetails.php?pid=<?php echo $row3['pid']; ?>"><?php echo $row3['pid']; ?></a>
                    </td>
                    <td>
                        <?php echo $row3['cost'] ?>
                    </td>
                    <td>
                        <?php echo $row3['bemail'] ?>
                    </td>
                    <td>
                        <a href="removepackage.php?pid=<?php echo $row3['pid']; ?>"><button
                                class="w3-button txt w3-red w3-center">Remove Package</button>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div id="Customers" class="w3-container tab" style="display:none">
        <div class="w3-responsive">
            <table class="w3-table-all txt">
                <tr class="w3-fc txtb">
                    <th>
                        Customer Name
                    </th>
                    <th>
                        Customer Email
                    </th>
                    <th>
                        Customer Contact
                    </th>
                    <th>
                        Remove Customer
                    </th>
                </tr>
                <?php while ($row4 = $ret4->fetchArray(SQLITE3_BOTH)) { ?>
                <tr class="txt">
                    <td>
                        <?php echo ucwords($row4['name']) ?>
                    </td>
                    <td>
                        <?php echo $row4['email'] ?>
                    </td>
                    <td>
                        <?php echo $row4['contact']; ?>
                    </td>
                    <td>
                        <a href="removeaccount.php?email=<?php echo $row4['email']; ?>"><button
                                class="w3-button txt w3-red w3-center">Remove Customer</button>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <script>
    function openTab(evt, TabName) {
        var i, x, tablinks;
        var x = document.getElementsByClassName("tab");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-fc", "");
        }
        document.getElementById(TabName).style.display = "block";
        evt.currentTarget.className += " w3-fc";
    }
    setTimeout("location.reload(true);", 300000);
    </script>
</body>