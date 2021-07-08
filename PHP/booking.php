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
        header('Refresh: 2; URL=../HTML/login.html');
        echo '<h3 class="txt w3-center">Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
        exit();
    }
    $email = $_COOKIE["loginemail"];
    $count = $_POST["count"];
    $pid = $_POST["pid"];
    $dur = $_POST["dur"];
    if (!isset($_COOKIE["loginemail"])) {
        header('Refresh: 2; URL=../HTML/login.html');
        echo '<h3 class="w3-center txt">You are not logged in, please login. Redirecting you to login page</h3>';
        exit();
    }
    ?>
    <!-- Navigation Bar -->
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
    <br>
    <div class="w3-container">
        <h2 class="w3-center txt">Fill out details about the people you are booking this form for...</h2>
        <h4 class="w3-center txt">All fields are mandatory*. You have to provide <b>accurate information*</b> for each
            individual
        </h4>
    </div>
    <form class="w3-container w3-round centerf w3-card w3-fc txt" action="bookingconfirm.php" method="post"
        enctype="multipart/form-data">
        <h4 class="w3-center txt">Details about individual days</h4>
        <br>
        <?php
        for ($i = 1; $i <= $count; $i++) {
        ?>
        <h4 class="w3-center txt">Individual <?php echo $i; ?></h4>
        <div class="w3-row-padding">
            <div class="w3-third">
                <label>Name</label>
                <input class="w3-input w3-border" type="text" name="name<?php echo $i; ?>"
                    placeholder="Name of the person" required>
            </div>
            <div class="w3-third">
                <label>Age</label>
                <input class="w3-input w3-border" type="number" name="age<?php echo $i; ?>" min="2" max="80"
                    placeholder="Age in number" required>
            </div>
            <div class="w3-third">
                <label>Aadhar Identification No.</label>
                <input class="w3-input w3-border" type="number" name="id<?php echo $i; ?>" minlength="12" maxlength="12"
                    placeholder="12 digit Aadhar ID" required>
            </div>
        </div>
        <br>
        <?php
        } ?>
        </div>
        <br>
        <h4 class="w3-center txt">Select a date to book your package</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-row-padding">
                <label for="date">Date has to be atleast <b>15 days</b> from today and at most <b>3 months</b> from
                    today*</label>
                <input id="date" class="w3-input w3-border" type="date" name="date"
                    min="<?php $date = date("Y-m-d");
                                                                                            echo date('Y-m-d', strtotime($date . ' + 15 days')); ?>"
                    max="<?php $date = date("Y-m-d");
                                                                                                                                                            echo date('Y-m-d', strtotime($date . ' + 3 months')); ?>"
                    required />

            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Enter your bank account number to make this purchase</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-row-padding">
                <label>You can only use <b>this account number</b> to make this purchase*</label>
                <input id="accno" class="w3-input w3-border" type="number" name="accno"
                    placeholder="9-18 digit account number" required>
            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Type the phrase "confirm" to proceed booking the package</h4>
        <div class="w3-row-padding">
            <div class="w3-row-padding">
                <input id="confirm" class="w3-input w3-border" type="text" name="confirm"
                    placeholder="type confirm here" required>
            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Total cost for
            <?php echo (string)$count . " individuals : " . '<span
                            style="font-family: sans-serif;">₹</span>' . (string)$_POST["cost"] * $count; ?>
        </h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-row-padding">
                <input class="w3-check" type="checkbox" name="agree" value="Agreed" required>
                <label>I agree to all the <a href="../HTML/tc.html">terms and condition</a></label>
            </div>
        </div>
        <br>
        <!-- hidden inputs -->
        <input class="w3-input w3-border" type="hidden" name="pid" value="<?php echo $pid; ?>">
        <input class="w3-input w3-border" type="hidden" name="count" value="<?php echo $count; ?>">
        <input class="w3-input w3-border" type="hidden" name="dur" value="<?php echo $dur; ?>">

        <div class="w3-row-padding">
            <div class="w3-rest w3-center">
                <br>
                <input class="w3-button w3-green " type="submit" id="submit" name="upload"
                    value="Proceed to next fillup" disabled>
            </div>
        </div>
    </form>
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
    <script>
    let input = document.querySelector("#confirm");
    let button = document.querySelector("#submit");

    button.disabled = true; //setting button state to disabled

    input.addEventListener("input", stateHandle);

    function stateHandle() {
        if (input.value === "confirm") {
            button.disabled = false; //button remains disabled
        } else {
            button.disabled = true; //button is enabled
        }
    }
    </script>
</body>

</html>