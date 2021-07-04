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
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
if (!isset($_COOKIE["bloginemail"])) {
    header('Refresh: 2; URL=../HTML/blogin.html');
    echo '<h3>You are not logged in, redirecting to login</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["bloginemail"];
?>

<body>
    <!-- Navigation Bar -->
    <div>
        <div class="w3-bar w3-xxlarge nav">
            <a href="account.php" class="w3-bar-item w3-button w3-mobile w3-padding-16 join"><img
                    src="../android-chrome-192x192.png" alt="Home Logo" width="62"></a>
            <a href="../PHP/blogout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Logout</a>
            <a href="../HTML/business.html" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Home</a>
            <a href="#" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Welcome
                <?php echo $_COOKIE["bname"]; ?> </a>
            <a href="../PHP/bsettings.php"
                class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join w3-fc">Your
                Profile</a>
        </div>
    </div>
    <div class="w3-container">
        <h3 class="w3-center txt">Packages that customers have booked</h3>
    </div>
    <br>
    <?php
    $sql = "SELECT * FROM pkg_info,
    packages
    WHERE packages.pid = pkg_info.pid AND packages.bemail = '$email' AND iscancelled = 0";
    $ret = $db->query($sql);
    while ($row = $ret->fetchArray(SQLITE3_BOTH)) {
    ?>
    <div class="w3-responsive">
        <div class="w3-container">
            <table class="w3-table-all txt">
                <tr class="w3-fc txtb">
                    <th>
                        Package ID
                    </th>
                    <th>
                        Package Name
                    </th>
                    <th>
                        Booked by
                    </th>
                    <th>
                        From date
                    </th>
                    <th>
                        To date
                    </th>
                    <th>
                        Cost per person
                    </th>
                    <th>
                        Individual Count
                    </th>
                    <th>
                        Total cost
                    </th>
                    <th>
                        Account number of customer
                    </th>
                    <th>
                        Approval status
                    </th>
                    <th>
                        Paid status
                    </th>
                </tr class="w3-fc">
                <td>
                    <?php echo $row['pid'] ?>
                </td>
                <td>
                    <?php echo $row['name'] ?>
                </td>
                <td>
                    <?php echo $row['email'] ?>
                </td>
                <td>
                    <?php echo $row['fromdate'] ?>
                </td>
                <td>
                    <?php echo $row['todate'] ?>
                </td>
                <td>
                    <?php echo $row['cost'] ?>
                </td>
                <td>
                    <?php
                        $sql2 = "SELECT count(*) AS gcount
                        from guest_info
                        where bid = '$row[bid]'";
                        $ret2 = $db->query($sql2);
                        $row2 = $ret2->fetchArray(SQLITE3_BOTH);
                        echo $row2['gcount'] ?>
                </td>
                <td>
                    <?php echo $row['cost'] * $row2['gcount']; ?>
                </td>
                <td>
                    <?php echo $row['caccno']; ?>
                </td>
                <td>
                    <?php echo ($row['approval'] == 1) ? "Approved" :  "Not approved"; ?>
                </td>
                <td>
                    <?php echo ($row['ispaid'] == 1) ? "Paid" :  "Not paid"; ?>
                </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <?php
        if (strtotime("now") > strtotime($row['fromdate'] . "- 5days")) {
            $bidc = $row['bid'];
            $sqlcancel = "UPDATE pkg_info SET iscancelled = 1 WHERE bid ='$bidc'";
            $retc = $db->exec($sqlcancel);
        }
        ?>
    <div class="w3-container">
        <?php if ($row['approval'] == 0) { ?>
        <div class=" w3-center">
            <h4 class="txt w3-center">You can choose to aprrove or not approve this package.<b> But once you approve you
                    cannot cancel it
                    later from here*</b></h4>
            <form method="POST" action="papprove.php">
                <input class="w3-button w3-green" type="submit" name="approval" value="Approve" />
                <input class="w3-button w3-red" type="submit" name="approval" value="Cancel" />
                <input class="w3-button w3-green" type="hidden" name="bid" value="<?php echo $row['bid']; ?>" />
            </form>
        </div>
        <?php } elseif ($row['approval'] == 1 && $row['ispaid'] == 0) { ?>
        <h4 class="txt w3-center">The payment proof sent by the customer will appear here.<b> You need to verify through
                the picture the full amount is sent to your account number through the customer's account number given
                in the table*. If the payment was not done from the account number mentioned in the table, refund the
                amount to the same account number the payment came from and reject the payment.</b>
        </h4>
        <?php if ($src = glob("../payimage/" . $row['bid'] . ".*")) { ?>
        <div class="w3-center w3-display-container">
            <img class="img3" src="<?php echo $src[0]; ?>" alt="payproof">
            <br>
            <br>
            <form method="POST" action="payapprove.php">
                <input class="w3-button w3-green" type="submit" name="pay" value="Approve pay" />
                <input class="w3-button w3-red" type="submit" name="pay" value="Reject" />
                <input class="w3-button w3-green" type="hidden" name="bidp" value="<?php echo $row['bid']; ?>" />
            </form>
        </div>
        <?php } ?>
        <?php } else { ?>
        <h4 class="txt w3-center">This package is approved and paid for by the customer. You must contact the customer's
            email and send them further details.<b> Failing to deliver, you must refund entire amount*</b>.
        </h4>
        <?php } ?>
    </div>
    <div class=" w3-container">
        <hr style="border: 5px solid var(--deeper);
  border-radius: 5px;">
    </div>
    <?php
    }
    ?>
</body>
<script>
setTimeout("location.reload(true);", 300000);
</script>

</html>