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
    header('Refresh: 2; URL=../HTML/index.html');
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
} ?>

<body>
    <div class="w3-container w3-center">
        <h2 class="txt w3-center">Admin login</h2>
        <br>
        <button onclick="document.getElementById('id01').style.display='block'"
            class="w3-button w3-green txt w3-center w3-large">Login</button>

        <div id="id01" class="w3-modal">
            <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                <div class="w3-center"><br>
                    <span onclick="document.getElementById('id01').style.display='none'"
                        class="w3-button w3-xlarge w3-transparent w3-display-topright" title="Close Modal">×</span>
                    <img src="../profile.jpg" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
                </div>

                <form class="w3-container txt" action="adminpage.php" method="GET">
                    <div class="w3-section">
                        <label><b>Email</b></label>
                        <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter Username"
                            name="email" required>
                        <label><b>Password</b></label>
                        <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="pass"
                            required>
                        <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
                    </div>
                </form>

                <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                    <button onclick="document.getElementById('id01').style.display='none'" type="button"
                        class="w3-button w3-red">Cancel</button>
                </div>

            </div>
        </div>
    </div>
</body>

</html>