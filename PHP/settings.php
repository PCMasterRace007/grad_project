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
$sqlp = "SELECT pimage FROM customers WHERE email = '$email'";
$retp = $db->query($sqlp);
if (!($rowp = $retp->fetchArray(SQLITE3_BOTH))) {
    $link = "../profile.jpg";
} elseif ($rowp['pimage'] == null) {
    $link = "../profile.jpg";
} else {
    $link = "../pimage/" . $rowp['pimage'];
}
?>

<body>
    <!-- Navigation Bar -->
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

    <div class="w3-card-4 w3-round txt">
        <div class="w3-container">
            <h3 class="w3-center txt">My Profile</h3>
            <p class=" w3-center"><img src="<?php echo $link; ?>" class="w3-circle" style="height:106px;width:106px"
                    alt="Avatar"></p>

            <div class="w3-container w3-center">
                <Button onclick="document.getElementById('id01').style.display='block'"
                    class="centerb w3-button w3-green"><i class="fas fa-edit"></i>
                    Change profile picture</Button>
                <div id="id01" class="w3-modal">
                    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                        <div class="w3-center"><br>
                            <span onclick="document.getElementById('id01').style.display='none'"
                                class="w3-button w3-xlarge w3-transparent w3-display-topright w3-hover-red"
                                title="Close Modal">??</span>
                        </div>
                        <form class="w3-container" action="pupload.php" method="POST" enctype="multipart/form-data">
                            <div class="w3-section">
                                <label><b>Choose file</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="file" name="pic" id="pic"
                                    value="" required />
                                <input class="w3-input w3-border w3-button w3-green" type="submit"
                                    value="Upload Profile Image" name="upload" />
                            </div>
                        </form>
                        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                            <button onclick="document.getElementById('id01').style.display='none'" type="button"
                                class="w3-button w3-red">Cancel</button>
                        </div>

                    </div>
                </div>

            </div>
            <hr>
            <div class="w3-card-4 center w3-bc round">
                <h4 class="w3-center">Name : <?php echo $_COOKIE["name"]; ?></h4>
            </div>
            <br>
            <div class="w3-card-4 center w3-bc round">
                <h4 class="w3-center">Email : <?php echo $_COOKIE["loginemail"]; ?></h4>
            </div>
            <br>
            <div class="w3-card-4 center w3-bc round">
                <h4 class="w3-center">contact : <?php echo $_COOKIE["contact"]; ?></h4>
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
                            title="Close Modal">??</span>
                    </div>

                    <form class="w3-container" action="passcheck.php" method="POST">
                        <div class="w3-section">
                            <label><b>Confirm Your Profile Password</b></label>
                            <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="pass"
                                required />
                            <button class="w3-button w3-block w3-green w3-section w3-padding"
                                type="submit">Submit</button>
                        </div>
                    </form>

                    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey w3-center">
                        <button onclick="document.getElementById('id01').style.display='none'" type="button"
                            class="w3-button w3-red ">Cancel</button>
                    </div>

                </div>
            </div>
            <h3 class="w3-center txt w3-padding-32">My Bookings</h3>
            <?php
            $sql = "SELECT bid FROM pkg_info WHERE email = '$email'";
            $ret = $db->query($sql);
            $row = $ret->fetchArray(SQLITE3_BOTH);
            if ($row['bid'] == null) {
                echo '<h4 class="txt w3-center parad>No Bookings available</h4>';
                $db->close();
                //break;
            } else {
                $ret = $db->query($sql);
                while ($row = $ret->fetchArray(SQLITE3_BOTH)) { ?>
            <div class="w3-card-4 center w3-bc round">
                <a href="showbooking.php?bid=<?php echo $row['bid']; ?>">
                    <h4 class=" w3-center txt parad">Booking
                        ID :
                        <?php echo $row['bid']; ?>
                </a>
                </h4>
            </div>
            <br>
            <?php
                }
                $db->close();
            }
            $db->close();
            ?>

        </div>
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