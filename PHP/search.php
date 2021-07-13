<?php
$dest = strtolower($_POST["dest"]);
$sql = "SELECT pid,
name,
dest,
dur,
cost,
places,
food,
ttype,
route,
activities,
[desc],
islisted,
bemail,
stag1,
stag2,
stag3,
stag4
FROM packages
WHERE ( dest = '$dest' COLLATE NOCASE OR stag1 = '$dest' COLLATE NOCASE OR stag2 = '$dest' COLLATE NOCASE OR stag2 = '$dest' COLLATE NOCASE OR stag4 = '$dest' COLLATE NOCASE) AND islisted = 1";
?>
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
</head>

<body>
    <!-- Navigation Bar -->
    <?php
    if (isset($_COOKIE["loginemail"])) {
    ?>
    <div>
        <div class="w3-bar w3-xxlarge nav">
            <a href="account.php" class="w3-bar-item w3-button w3-mobile w3-padding-16 join"><img
                    src="../android-chrome-192x192.png" alt="Home Logo" width="62"></a>
            <a href="../PHP/logout.php" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Logout</a>
            <a href="../PHP/settings.php"
                class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Account</a>
            <a href="#" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Welcome
                <?php echo $_COOKIE["name"]; ?> </a>
        </div>
    </div>
    <?php } else { ?>
    <div>
        <div class="w3-bar w3-xxlarge nav">
            <a href="index.html" class="w3-bar-item w3-button w3-mobile w3-padding-16 join"><img
                    src="../android-chrome-192x192.png" alt="Home Logo" width="62"></a>
            <a href="signup.html" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">SignUp</a>
            <a href="login.html" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Login</a>
            <a href="aboutus.html" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">About Us</a>
            <a href="business.html" class="w3-bar-item w3-button w3-mobile w3-right w3-padding-32 join">Not a
                Customer?</a>
        </div>
    </div>
    <?php } ?>
    <br>
    <br>
    <?php if (!$_POST["dest"] == "") { ?>
    <h2 class="w3-center txt">Search results for <?php echo $dest; ?> ...</h2>
    <?php } else {
        $sql = "SELECT pid,
        name,
        dest,
        dur,
        cost,
        places,
        food,
        ttype,
        route,
        activities,
        [desc],
        islisted,
        bemail,
        stag1,
        stag2,
        stag3,
        stag4
   FROM packages;
 " ?>
    <h2 class="w3-center txt">You did not search for a destination, showing all packages...</h2>
    <?php } ?>
    <br>
    <div class="w3-content">
        <form action="search.php" method="POST">
            <div class="w3-twothird w3-margin">
                <input class="w3-input w3-border" type="text" name="dest" placeholder="Search another destination">
            </div>
            <div class="w3-rest w3-margin">
                <p><input type="submit" class="w3-button btn-color txt" value="Search for packages" name="search" /></p>
            </div>
        </form>
    </div>
    <br>
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
        header('Refresh: 2; URL=../HTML/login.html');
        echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
        exit();
    }

    $ret = $db->query($sql); ?>
    <div class="w3-contentp">
        <?php
        while ($row = $ret->fetchArray(SQLITE3_BOTH)) {
            $desc = json_decode($row['desc'], true);
            $pid = $row['pid'];
            $sql2 = "SELECT
            image
            FROM pacimage
            WHERE pid = '$pid'";
            $ret2 = $db->query($sql2);
            $row2 = $ret2->fetchArray(SQLITE3_BOTH);
        ?>
        <div class="w3-row w3-margin w3-dc ">
            <div class="w3-third ">
                <img class="img" src="<?php echo "../pacimage/" . $row2['image']; ?> ">
            </div>

            <div class="w3-twothird w3-container w3-text-black">
                <h3 class=" txt"><strong><?php echo $row['name']; ?></strong>
                </h3>
                <h4 class=" txt">
                    <?php echo (string)$row['dur'] . " Nights " . (string)($row['dur'] + 1) . " Days " .  "tour covering " . $row['places']; ?>
                </h4>
                <p class="para txt">
                    <?php echo $desc['desc']; ?>
                </p>
                <p class=" txt">Cost: <span style="font-family: sans-serif;">₹</span><?php echo $row['cost']; ?></p>
                <br>
                <a href="<?php echo "searchdetails.php?pid=" .  $row['pid']; ?>"><button class="w3-button w3-fc">
                        View Package </button></a>
            </div>
        </div>
        <br>
        <?php
        }
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