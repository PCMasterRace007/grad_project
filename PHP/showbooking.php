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
    <link rel="stylesheet" href="../CSS/style.css">
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
    header('Refresh: 2; URL=../HTML/login.html');
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
if (!isset($_COOKIE["loginemail"])) {
    header('Refresh: 2; URL=../HTML/login.html');
    echo '<h3 class="w3-center txt">You are not logged in, please login. Redirecting you to login page</h3>';
    $db->close();
    exit();
}
$email = $_COOKIE["loginemail"];
$bid = $_GET["bid"];
$sql = "SELECT *
FROM pkg_info
WHERE bid = '$bid'";
$ret = $db->query($sql);
$row = $ret->fetchArray(SQLITE3_BOTH);
$pid = $row['pid'];
$from = $row['fromdate'];
$to = $row['todate'];
$approve = $row['approval'];
$ispaid = $row['ispaid'];
$accno = $row['caccno'];
$iscancelled = $row['iscancelled'];
$sql2 = "SELECT name, cost, bemail FROM packages WHERE pid = '$pid'";
$ret2 = $db->query($sql2);
$row2 = $ret2->fetchArray(SQLITE3_BOTH);
$name = $row2['name'];
$count;
?>

<body>
    <div>
        <div class="w3-bar w3-xxlarge nav">
            <a href="account.php" class="w3-bar-item w3-button w3-mobile w3-padding-16 join"><img
                    src="../android-chrome-192x192.png" alt="Home Logo" width="62"></a>
            <a href="../PHP/logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Logout</a>
            <a href="../PHP/account.php" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Home</a>
            <a href="#" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Welcome
                <?php echo $_COOKIE["name"]; ?> </a>
            <a href="../PHP/settings.php" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join w3-fc">Your
                Profile</a>
        </div>
    </div>
    <br>
    <div class="w3-container">
        <h3 class="txt w3-center parad">Package details</h3>
    </div>
    <br>
    <div class="w3-responsive">
        <div class="w3-container">
            <table class="w3-table-all">
                <tr class="w3-fc txtb">
                    <th>
                        Booking ID
                    </th>
                    <th>
                        Package name
                    </th>
                    <th>
                        FromDate
                    </th>
                    <th>
                        ToDate
                    </th>
                    <th>
                        Approved by agency ?
                    </th>
                    <th>
                        Is paid for ?
                    </th>
                    <th>
                        Bank account number that will be used to pay for this package
                    </th>
                    <th>
                        Cost per person
                    </th>
                    <th>
                        Is cancelled ?
                    </th>
                </tr>
                <tr class="txt">
                    <td>
                        <?php echo $bid; ?>
                    </td>
                    <td>
                        <?php echo "<a href = searchdetails.php?pid=$pid>$name</a>"; ?>
                    </td>
                    <td>
                        <?php echo $from; ?>
                    </td>
                    <td>
                        <?php echo $to; ?>
                    </td>
                    <td>
                        <?php echo ($approve == 1) ? "Yes" : "No"; ?>
                    </td>
                    <td>
                        <?php echo ($ispaid == 1) ? "Yes" : "No"; ?>
                    </td>
                    <td>
                        <?php echo $accno; ?>
                    </td>
                    <td>
                        <?php echo  $row2['cost']; ?>
                    </td>
                    <td>
                        <?php echo ($iscancelled == 1) ? "Yes" : "No"; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <div class="w3-container">
        <h3 class="txt w3-center parad">Guest details</h3>
    </div>
    <br>
    <div class="w3-responsive">
        <div class="w3-container">
            <table class="w3-table-all">
                <tr class="w3-fc txtb">
                    <th>
                        Guest Name
                    </th>
                    <th>
                        Guest age
                    </th>
                    <th>
                        Guest ID
                    </th>
                </tr>
                <?php
                $sql3 = "SELECT gemail,
            name,
            age,
            bid,
            id,
            slno
            FROM guest_info
            WHERE bid = '$bid'";
                $ret3 = $db->query($sql3);
                while ($row3 = $ret3->fetchArray(SQLITE3_BOTH)) {
                    $count++;
                ?>
                <tr class="txt">
                    <td>
                        <?php echo $row3['name']; ?>
                    </td>
                    <td>
                        <?php echo $row3['age']; ?>
                    </td>
                    <td>
                        <?php echo $row3['id']; ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="w3-container">
        <br>
        <?php if (strtotime("now") > strtotime($to) && $iscancelled === 0 && $approve === 1 && $ispaid === 1) { ?>
        <h3 class="txt w3-center">Review</h3>
        <br>
        <h4 class="txt w3-center">Looks like you completed this tour. You can submit a review for this pacakge to share
            your experience.</h4>
        <?php $sqlreview = "SELECT rimage, description, rating FROM review WHERE bid = '$bid'";
            $retreview = $db->query($sqlreview);
            $rowreview = $retreview->fetchArray(SQLITE3_BOTH);
            if (!$rowreview) { ?>
        <br>
        <h4 class="txt w3-center">Review form</h4>
        <form class="w3-container w3-round centerf w3-card w3-fc txt" action="submitreview.php" method="POST"
            enctype="multipart/form-data">
            <label>Rating</label>
            <select class="w3-select w3-border" type="number" name="rating" required>
                <option value="" disabled selected>Choose a rating between 1 and 5. 1 being the lowest and 5 being
                    highest.</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br>
            <label>Description</label>
            <textarea class="w3-input w3-border" name="review" cols="30" rows="5" required
                placeholder="Describe your experience with this tour." required></textarea>
            <br>
            <label>You can also upload a picture</label>
            <input class="w3-input w3-border w3-margin-bottom" type="file" name="rimage" required />
            <input class="w3-input w3-border w3-margin-bottom" type="hidden" name="pid" value="<?php echo $pid; ?>"
                required />
            <input class="w3-input w3-border w3-margin-bottom" type="hidden" name="bid" value="<?php echo $bid; ?>"
                required />
            <input class="w3-button w3-green w3-center" type="submit" name="submit" value="submit" required />
        </form>
        <?php } else {
                echo '<h4 class="txt w3-center">You already have submitted your review for this package.</h4>';
            }
        } ?>
        <br>
        <h3 class="txt w3-center parad">Payment</h3>
        <br>
        <?php
        if ($approve === 0 && $iscancelled === 0) { ?>
        <h4 class="txt w3-center parad">This package is not yet approved by the agency, once they approve it you can pay
            for this package.</h4>
        <?php } elseif ($iscancelled === 1 && $ispaid === 0) { ?>
        <h4 class="txt w3-center">This package was cancelled by the agency. <b>If you had paid for the package and were
                not
                refunded within 48 hours please email us at: <a
                    href="mailto:admin@indixplore.com">admin@indixplore.com</a></b>
        </h4>
        <?php } elseif ($approve === 1 && $ispaid === 0 && strtotime($from) < strtotime(date("Y-m-d"))) {  ?>
        <h4 class="txt w3-center">This package was approved but you did not pay for it within stipulated time. So it was
            cancelled.</h4>
        <?php } elseif ($approve === 1 && $ispaid === 1 && $iscancelled === 0) { ?>
        <h4 class="txt w3-center">This package is paid for and approved by the agency.You will be emailed by the agency
            on further details. Here is the email address of the agency if you need to contact the agency :
            <?php echo $row2['bemail']; ?></h4>
        <br>
        <?php if (strtotime($from . "- 3days") > strtotime(date("Y-m-d"))) { ?>
        <div class="w3-container w3-center">
            <a href="cancelbooking.php?bid=<?php echo $bid; ?>"><button class=" w3-button txt w3-center w3-red">Cancel
                    this package</button></a>
        </div>
        <?php } ?>
        <br>
        <?php } elseif ($approve === 1 && $ispaid === 1 && $iscancelled === 1) { ?>
        <h4 class="txt w3-center">This package is flagged to be cancelled. The agency will cancel it and refund your
            payment.</h4>
        <br>
        <?php } else { ?>
        <h4 class="txt w3-center parad"><i class="fas fa-money-check-alt"></i> Total Cost: <span
                style="font-family: sans-serif;">₹</span><?php echo $count * $row2['cost']; ?></h4>
        <h4 class="txt w3-center parad">This package is approved by the agency, you can now
            pay
            for this package.</h4>
        <h4 class="txt w3-center">Please send the total amount for this package to this account listed below. <b>The
                transaction
                must occur from the same account number you listed when you booked this package or else the package
                will
                be rejected*</b>. You can find that
            information in
            the first table.</h4>
        <?php
            $bemail = $row2['bemail'];
            $sql4 = "SELECT accno, ifsc FROM business WHERE email = '$bemail'";
            $ret4 = $db->query($sql4);
            $row4 = $ret4->fetchArray(SQLITE3_BOTH);
            ?>
        <h4 class="txt w3-center parad">Account no. : <?php echo $row4['accno'] ?></h4>
        <h4 class="txt w3-center parad">IFSC : <?php echo $row4['ifsc'] ?></h4>
        <h4 class="txt w3-center parad">You have to send the amount before :
            <?php echo date("Y-m-d", strtotime($from . "- 5days")); ?> or the package will be cancelled.</h4>
        <br>
        <h3 class="txt w3-center parad">Payment proof</h3>
        <br>
        <?php
            $fname = "../payimage/" . $bid . ".*";
            if (glob($fname)) { ?>
        <h4 class="w3-center txt">You have already submitted proof of your payment. It will be checked by the agency and
            will be approved if found legitimate.</h4>
        <?php } else {
            ?>
        <h4 class="txt w3-center">Send a picture of the completed transaction of the payment you made to the
            agency from the account number you mentioned during yopur booking. The image must be less than <b>1MB</b> in
            size*.
        </h4>
        <div class="w3-modal-content w3-fc w3-round" style=" max-width:600px;">
            <form class="w3-container w3-text-black txt" action="paymentproof.php" method="POST"
                enctype="multipart/form-data">
                <div class="w3-section">
                    <label><b>Choose file</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="file" name="proof" id="proof" />
                    <input class="w3-input w3-border w3-margin-bottom" type="hidden" name="bid"
                        value="<?php echo $bid; ?>" />
                    <input class="w3-input w3-border w3-button w3-green w3-text-black" type="submit"
                        value="Upload Payment Proof" name="upload" />
                </div>
            </form>
        </div>
        <br>
        <?php } ?>
        <?php }
        $db->close();
        //exit();
        ?>
    </div>
    <br>
    <footer class="w3-container w3-center w3-opacity nav">
        <h5>Find Us On</h5>
        <div class="w3-xlarge w3-padding-large">
            <i class="fa fa-facebook-official w3-hover-opacity"></i>
            <i class="fa fa-instagram w3-hover-opacity"></i>
            <i class="fa fa-snapchat w3-hover-opacity"></i>
            <i class="fa fa-pinterest-p w3-hover-opacity"></i>
            <i class="fa fa-twitter w3-hover-opacity"></i>
            <i class="fa fa-linkedin w3-hover-opacity"></i>
        </div>
    </footer>
</body>