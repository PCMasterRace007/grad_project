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

    <div class="w3-card-4 w3-round txt">
        <div class="w3-container">
            <h3 class="w3-center txt">My Business Profile</h3>
        </div>
        <hr>
        <div class="w3-card-4 center w3-bc round">
            <h4 class="w3-center">Name : <?php echo $_COOKIE["bname"]; ?></h4>
        </div>
        <br>
        <div class="w3-card-4 center w3-bc round">
            <h4 class="w3-center">Email : <?php echo $_COOKIE["bloginemail"]; ?></h4>
        </div>
        <br>
        <div class="w3-card-4 center w3-bc round">
            <h4 class="w3-center">Contact : <?php echo $_COOKIE["bcontact"]; ?></h4>
        </div>
        <br>
        <div class=" w3-center">
            <Button onclick="document.getElementById('id02').style.display='block'"
                class="centerb w3-button w3-green"><i class="fas fa-edit"></i>
                Edit info/Change Password</Button>
        </div>
        <div id="id02" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                <div class="w3-center"><br>
                    <span onclick="document.getElementById('id02').style.display='none'"
                        class="w3-button w3-xlarge w3-transparent w3-display-topright w3-hover-red"
                        title="Close Modal">×</span>
                </div>

                <form class="w3-container" action="bpasscheck.php" method="POST">
                    <div class="w3-section">
                        <label><b>Confirm Your Business Password</b></label>
                        <input class="w3-input w3-border" type="text" placeholder="Enter Password" name="pass"
                            required />
                        <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Submit</button>
                    </div>
                </form>

                <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-center">
                    <button onclick="document.getElementById('id02').style.display='none'" type="button"
                        class="w3-button w3-red ">Cancel</button>
                </div>

            </div>
        </div>
        <h3 class="w3-center txt w3-padding-32">My Payment Information</h3>
        <?php
        $sql2 = "SELECT ifsc, accno FROM business WHERE email = '$email'";
        $ret2 = $db->query($sql2);
        $row2 = $ret2->fetchArray(SQLITE3_BOTH);
        if ($row2['accno'] == null || $row2['ifsc'] == null) {
            echo '<h4 class="txt w3-center">No payment information provided.</h4><br>';
        } else { ?>
        <div class="w3-card-4 center w3-bc round">
            <h4 class="w3-center txt parad"><?php echo "Account number : " . $row2['accno']; ?>
            </h4>
        </div>
        <br>
        <div class="w3-card-4 center w3-bc round">
            <h4 class="w3-center txt parad"><?php echo "IFSC : " . $row2['ifsc']; ?>
            </h4>
        </div>
        <br>
        <?php
        }
        ?>
        <div class=" w3-center">
            <Button onclick="document.getElementById('id03').style.display='block'"
                class="centerb w3-button w3-green"><i class="fas fa-plus-circle"></i>
                Add/change Payment information</Button></a>
        </div>

        <div id="id03" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                <div class="w3-center"><br>
                    <span onclick="document.getElementById('id03').style.display='none'"
                        class="w3-button w3-xlarge w3-transparent w3-display-topright w3-hover-red"
                        title="Close Modal">×</span>
                </div>

                <form class="w3-container" action="baddpayment.php" method="POST">
                    <div class="w3-section">
                        <label><b>Confirm Your Business Password</b></label>
                        <input class="w3-input w3-border" type="text" placeholder="Enter Password" name="passc"
                            required />
                        <br>
                        <label><b>Enter bank IFSC code</b></label>
                        <input class="w3-input w3-border" type="text" placeholder="Enter 11 digit IFSC" name="ifsc"
                            required />
                        <br>
                        <label><b>Enter your bank account number</b></label>
                        <input class="w3-input w3-border" type="number" placeholder="Enter 9-18 digit account number"
                            name="accno" required />
                        <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Submit</button>
                    </div>
                </form>

                <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-center">
                    <button onclick="document.getElementById('id03').style.display='none'" type="button"
                        class="w3-button w3-red ">Cancel</button>
                </div>
            </div>
        </div>
        <br>
        <h3 class="w3-center txt w3-padding-32">Manage</h3>
        <div class=" w3-center">
            <a href="addlisting.php"><Button class="centerb w3-button w3-green"><i class="fas fa-plus-circle"></i>
                    Add listings</Button></a>
        </div>
        <br>
        <div class=" w3-center">
            <a href="managebookings.php"><Button class="centerb w3-button w3-orange"><i class="far fa-edit"></i>
                    Manage pending bookings</Button></a>
        </div>
        <br>
        <div class=" w3-center">
            <a href="viewcancelledbookings.php"><Button class="centerb w3-button w3-red"><i
                        class="fas fa-times-circle"></i>
                    Refund canceled bookings</Button></a>
        </div>
        <br>
        <div class=" w3-center">
            <a href="viewbookings.php"><Button class="centerb w3-button w3-green"><i class="fas fa-eye"></i>
                    View completed bookings</Button></a>
        </div>
        <br>
        <h3 class="w3-center txt w3-padding-32">My listings</h3>
        <?php
        $sql = "SELECT pid FROM packages WHERE bemail = '$email'";
        $ret = $db->query($sql);
        if (!($row = $ret->fetchArray(SQLITE3_BOTH))) {
            echo '<h4 class="txt w3-center">No Listings available</h4>';
            $db->close();
            //exit();
        } else {
            $ret = $db->query($sql);
            while ($row = $ret->fetchArray(SQLITE3_BOTH)) { ?>
        <div class="w3-card-4 center w3-bc round">
            <h4 class="w3-center txt parad"><a href="showlisting.php?pid=<?php echo $row['pid']; ?>">Package ID :
                    <?php echo $row['pid']; ?></a>
            </h4>
        </div>
        <br>
        <?php
            }
            $db->close();
        }
        //exit();
        ?>

    </div>
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