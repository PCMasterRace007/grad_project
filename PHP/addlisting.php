<!DOCTYPE html>
<html lang="en">

<head>
    <title>indiXplore, let's travel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/settings.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/3bd38c0192.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/jpg" href="../android-chrome-512x512.png" />
</head>

<body>
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
    $checksql = "SELECT accno, ifsc FROM business WHERE email = '$email'";
    $checkret = $db->query($checksql);
    $checkrow = $checkret->fetchArray(SQLITE3_BOTH);
    //echo $checksql;
    if ($checkrow['accno'] == null || $checkrow['accno'] == null) {
        header('Refresh: 3; URL=bsettings.php');
        echo '<h4 class="txt w3-center">You do not have complete payment information added, therefore you cannot list a package. First add your payment information through your profile. You will be redirected.</h4>';
        $db->close();
        exit();
    }
    ?>
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
    <br>
    <div class="w3-container">
        <h2 class="w3-center txt">Fill out the form to add a package</h2>
        <h4 class="w3-center txt">All text fields are mandatory except Activities and layover in Route section* There
            must be atleast 4 visiting places*, these first four places will be included in search tags. If there are
            more visiting places include them in description.</h4>
    </div>
    <br>
    <form class="w3-container w3-round centerf w3-card w3-fc txt" action="addlistingfinal.php" method="post">
        <div class="w3-row-padding">
            <div class="w3-third">
                <label>Package ID</label>
                <input class="w3-input w3-border" type="text" name="pid" disabled selected
                    placeholder="Disabled. Will be generated automatically" />
            </div>
            <div class="w3-third">
                <label>Package Name</label>
                <input class="w3-input w3-border" type="text" name="name" required
                    placeholder="Name should be relevant to package" />
            </div>

            <div class="w3-third">
                <label>Destination</label>
                <input class="w3-input w3-border" type="text" name="dest" required
                    placeholder="Where is the package to." />
            </div>
        </div>
        <br>
        <div class="w3-row-padding">
            <div class="w3-half">
                <label>Duration</label>
                <input class="w3-input w3-border" type="number" name="dur" required min="3" max="30" name="dur"
                    placeholder="How many nights in the package." />
            </div>
            <div class="w3-half">
                <label>Cost Per Person</label>
                <input class="w3-input w3-border" type="number" name="cost" min="2000" max="200000" name="dur" required
                    placeholder="Per person cost." />
            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Visiting places</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-quarter">
                <label>Place 1</label>
                <input class="w3-input w3-border" type="text" name="p1" required placeholder="Location" />
            </div>

            <div class="w3-quarter">
                <label>Place 2</label>
                <input class="w3-input w3-border" type="text" name="p2" required placeholder="Location" />
            </div>
            <div class="w3-quarter">
                <label>Place 3</label>
                <input class="w3-input w3-border" type="text" name="p3" required placeholder="Location" />
            </div>
            <div class="w3-quarter">
                <label>Place 4</label>
                <input class="w3-input w3-border" type="text" name="p4" required placeholder="Location" />
            </div>
        </div>
        <br>
        <div class="w3-row-padding">
            <div class="w3-quarter">
                <label>Place 5</label>
                <input class="w3-input w3-border" type="text" name="p5" placeholder="Location" />
            </div>

            <div class="w3-quarter">
                <label>Place 6</label>
                <input class="w3-input w3-border" type="text" name="p6" placeholder="Location" />
            </div>
            <div class="w3-quarter">
                <label>Place 7</label>
                <input class="w3-input w3-border" type="text" name="p7" placeholder="Location" />
            </div>
            <div class="w3-quarter">
                <label>Place 8</label>
                <input class="w3-input w3-border" type="text" name="p8" placeholder="Location" />
            </div>
        </div>
        <br>
        <div class="w3-row-padding">
            <div class="w3-half">
                <label>Fooding</label>
                <select class="w3-select w3-border" type="number" name="food" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="w3-half">
                <label>Means of Travel</label>
                <select class="w3-select w3-border" type="number" name="travel" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1">Air</option>
                    <option value="0">Land</option>
                </select>
            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Route</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-quarter">
                <label>Start</label>
                <input class="w3-input w3-border" type="text" name="r1" value="Any location" disabled
                    placeholder="Any location" />
            </div>
            <div class="w3-quarter">
                <label>Layover 1</label>
                <input class="w3-input w3-border" type="text" name="r2" required placeholder="Location" />
            </div>
            <div class="w3-quarter">
                <label>Layover 2</label>
                <input class="w3-input w3-border" type="text" name="r3" required placeholder="Location" />
            </div>
            <div class="w3-quarter">
                <label>Destination</label>
                <input class="w3-input w3-border" type="text" name="r4" required placeholder="Location" />
            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Activities Included</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-quarter">
                <input class="w3-check" type="checkbox" name="a1" value="Hot air baloon">
                <label>Hot air Baloon</label>
            </div>
            <div class="w3-quarter">
                <input class="w3-check" type="checkbox" name="a2" value="Boating">
                <label>Boating</label>
            </div>
            <div class="w3-quarter">
                <input class="w3-check" type="checkbox" name="a3" value="Hiking">
                <label>Hiking</label>
            </div>
            <div class="w3-quarter">
                <input class="w3-check" type="checkbox" name="a4" value="Skiing">
                <label>Skiing/Sledging</label>
            </div>
        </div>
        <br>
        <div class="w3-row-padding">
            <div class="w3-rest w3-center">
                <br>
                <input class="w3-button w3-green " type="submit" value="Proceed to next fillup">
            </div>
        </div>
    </form>
</body>

</html>