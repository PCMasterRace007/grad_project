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
    $email = $_COOKIE["bloginemail"];
    $dur = $_POST["dur"];
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
        <h2 class="w3-center txt">Fill out these additional details</h2>
        <h4 class="w3-center txt">All fields are mandatory*. You have to provide 4 <b>unique/distinct images*</b>, each
            under
            1MB.
        </h4>
    </div>
    <form class="w3-container w3-round centerf w3-card w3-fc txt" action="addalldetails.php" method="post"
        enctype="multipart/form-data">
        <h4 class="w3-center txt">Details about individual days</h4>
        <br>
        <?php
        for ($i = 1; $i <= $dur; $i++) {
        ?>
        <div class="w3-row-padding">
            <div class="w3-rest">

                <label>Day <?php echo $i; ?></label>
                <textarea class="w3-input w3-border" name="d<?php echo $i; ?>" cols="30" rows="2" required
                    placeholder="Details about what happens in Day <?php echo $i; ?>."></textarea>
            </div>
        </div>
        <br>
        <?php
        } ?>
        </div>
        </div>
        <h4 class="w3-center txt">Description</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-rest">
                <textarea class="w3-input w3-border" name="desc" cols="30" rows="10" required
                    placeholder="Describe about the package. Please be elaborative but use less than 1000 words. Try to include all details."></textarea>
            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Choose images for your package</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-quarter">
                <input class="w3-input w3-border w3-margin-bottom" type="file" name="pic0" id="pic0" required />
            </div>
            <div class="w3-quarter">
                <input class="w3-input w3-border w3-margin-bottom" type="file" name="pic1" id="pic1" required />
            </div>
            <div class="w3-quarter">
                <input class="w3-input w3-border w3-margin-bottom" type="file" name="pic2" id="pic2" required />
            </div>
            <div class="w3-quarter">
                <input class="w3-input w3-border w3-margin-bottom" type="file" name="pic3" id="pic3" required />
            </div>
        </div>
        <br>
        <h4 class="w3-center txt">Do you want to list this package ?</h4>
        <br>
        <div class="w3-row-padding">
            <div class="w3-rest">
                <select class="w3-select w3-border" name="islisted" required>
                    <option value="" disabled selected>Choose your option</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
        <br>
        <div class="w3-row-padding">
            <div class="w3-rest">
                <input class="w3-check" type="checkbox" name="agree" value="Agreed" required>
                <label>I agree to all the <a href="../HTML/tc.html">terms and condition</a></label>
            </div>

        </div>
        <br>

        <input class="w3-input w3-border" type="hidden" name="pid" disabled selected
            placeholder="Disabled. Will be generated automatically" />


        <input class="w3-input w3-border" type="hidden" name="name" required value="<?php echo $_POST["name"]; ?>"
            placeholder="Name should be relevant to package" />


        <input class="w3-input w3-border" type="hidden" name="dest" value="<?php echo $_POST["dest"]; ?>" required
            placeholder="Where is the package to." />

        <input class="w3-input w3-border" type="hidden" name="dur" required min="3" max="30" name="dur"
            value="<?php echo $_POST["dur"]; ?>" placeholder="How many nights in the package." />

        <input class="w3-input w3-border" type="hidden" name="cost" min="2000" max="200000" name="dur"
            value="<?php echo $_POST["cost"]; ?>" required placeholder="Per person cost." />

        <input class="w3-input w3-border" type="hidden" name="p1" value="<?php echo $_POST["p1"]; ?>" required
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="p2" value="<?php echo $_POST["p2"]; ?>" required
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="p3" value="<?php echo $_POST["p3"]; ?>" required
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="p4" value="<?php echo $_POST["p4"]; ?>" required
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="p5" value="<?php echo $_POST["p5"]; ?>"
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="p6" value="<?php echo $_POST["p6"]; ?>"
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="p7" value="<?php echo $_POST["p7"]; ?>"
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="p8" value="<?php echo $_POST["p8"]; ?>"
            placeholder="Location" />
        <input class="w3-input w3-border" type="hidden" name="food" value="<?php echo $_POST["food"]; ?>"
            placeholder="Location" />
        <input class="w3-input w3-border" type="hidden" name="travel" value="<?php echo $_POST["travel"]; ?>"
            placeholder="Location" />

        <!-- <select style="display: none;" class="w3-select w3-border" name="food" type="hidden"
            value="">
             <option value="" disabled>Choose your option</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <select style="display: none;" class="w3-select w3-border" name="travel" type="hidden"
            value="">
             <option value="" selected disabled>Choose your option</option>
            <option value="1">Air</option>
            <option value="0">Land</option>
        </select>-->
        <!--From previous form-->
        <input class="w3-input w3-border" type="hidden" name="r1" value="<?php echo $_POST["r1"]; ?>" disabled
            placeholder="Any location" />
        <input class="w3-input w3-border" type="hidden" name="r2" value="<?php echo $_POST["r2"]; ?>" required
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="r3" value="<?php echo $_POST["r3"]; ?>" required
            placeholder="Location" />

        <input class="w3-input w3-border" type="hidden" name="r4" value="<?php echo $_POST["r4"]; ?>" required
            placeholder="Location" />

        <input class="w3-check" type="hidden" name="a1" value="<?php echo $_POST["a1"]; ?>">

        <input class="w3-check" type="hidden" name="a2" value="<?php echo $_POST["a2"]; ?>">

        <input class="w3-check" type="hidden" name="a3" value="<?php echo $_POST["a3"]; ?>">

        <input class="w3-check" type="hidden" name="a4" value="<?php echo $_POST["a4"]; ?>">

        <div class="w3-row-padding">
            <div class="w3-rest w3-center">
                <br>
                <input class="w3-button w3-green " type="submit" name="upload" value="Proceed to next fillup">
            </div>
        </div>
    </form>
</body>

</html>