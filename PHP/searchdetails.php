<?php
$pid = $_GET["pid"];
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
bemail
FROM packages
WHERE pid = '$pid'";
$sql2 = "SELECT image FROM pacimage WHERE pid = '$pid'";
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
    <style>
    .mySlides {
        display: none;
    }
    </style>

</head>

<body>
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

    $ret = $db->query($sql);
    $ret2 = $db->query($sql2);
    $row = $ret->fetchArray(SQLITE3_BOTH); ?>
    <div class="w3-container">
        <h2 class="w3-center txt">Package name: <?php echo $row['name']; ?></h2>
    </div>
    <br>
    <br>
    <div class="w3-contentp">
        <div class="w3-third w3-display-container">
            <img class="mySlides img3" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                            echo "../pacimage/" . $p1['image']; ?>">
            <img class="mySlides img3" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                            echo "../pacimage/" . $p1['image']; ?>">
            <img class="mySlides img3" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                            echo "../pacimage/" . $p1['image']; ?>">
            <img class="mySlides img3" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                            echo "../pacimage/" . $p1['image']; ?>">
            <button class="w3-button w3-fc w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
            <button class="w3-button w3-fc w3-display-right" onclick="plusDivs(1)">&#10095;</button>
        </div>
        <div class="w3-rest txt">
            <div class="w3-container margin">
                <h3 class="txt ">Destination : <?php echo $row['dest']; ?></h3>
                <h4 style="margin-top: 20px;" class="txt parad">Places covered with this tour :
                    <?php echo $row['places']; ?></h4>
                <h4 style="margin-top: 20px;" class="txt parad">Activities included :
                    <?php echo $row['activities']; ?></h4>
                <h4 style="margin-top: 20px;" class="txt parad">Fooding included : <?php if ($row['food']) {
                                                                                        echo "Yes";
                                                                                    } else {
                                                                                        echo "No";
                                                                                    } ?></h4>
                <h4 style="margin-top: 20px;" class="txt">Cost per person : <span
                        style="font-family: sans-serif;">₹</span><?php echo $row['cost']; ?></h4>
                <button onclick="document.getElementById('id02').style.display='block'" style="margin-top: 20px;"
                    class="w3-button w3-fc">Book this package</button>
                <div id="id02" class="w3-modal">
                    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

                        <div class="w3-center"><br>
                            <span onclick="document.getElementById('id02').style.display='none'"
                                class="w3-button w3-xlarge w3-transparent w3-display-topright w3-hover-red"
                                title="Close Modal">×</span>
                        </div>

                        <form class="w3-container" action="booking.php" method="POST">
                            <div class="w3-section">
                                <h4 class="w3-center txt">Only users who are logged can book a package. If you are
                                    not logged in you will be redirected to the login page.</h4>
                                <label><b>How many people do you want to book the package for</b></label>
                                <input class="w3-input w3-border" type="text" name="count" placeholder="Enter a number"
                                    required />
                                <input class="w3-input w3-border" type="hidden" name="cost"
                                    value="<?php echo $row['cost']; ?>" />
                                <input class="w3-input w3-border" type="hidden" name="pid"
                                    value="<?php echo $row['pid']; ?>" />
                                <input class="w3-input w3-border" type="hidden" name="dur"
                                    value="<?php echo $row['dur']; ?>" />
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
            </div>
        </div>

    </div>
    <br>
    <div class="w3-contentp">
        <div class=" w3-container w3-half">
            <br>
            <h3 style="margin-top: 20px;" class="w3-center txt">Route taken</h3>
            <br>
            <h4 class="txt w3-center"><i class="fas fa-route"></i> Your location
                <?php
                $route = explode(", ", $row['route']);
                foreach ($route as $value) {
                    echo "  &#10095;  ";
                    echo $value;
                }
                ?>
            </h4>
            <br>
        </div>
        <div class="w3-half w3-container">
            <br>
            <h3 style="margin-top: 20px;" class="w3-center txt">Means of travel</h3>
            <br>
            <h4 class="w3-center txt">
                <?php
                echo "The means of travel for this package is by " . $row['ttype'] . " ";
                if ($row['ttype'] == "Air") {
                    echo '  <i class="fas fa-plane-departure"></i>';
                } else {
                    echo '  <i class="fas fa-bus-alt"></i>';
                }
                ?>
            </h4>
            <br>
        </div>
    </div>
    <div class="w3-contentp">
        <div class=" w3-container">
            <br>
            <h3 style="margin-top: 20px;" class="w3-center txt">Details about individual days</h3>
            <br>
            <?php
            $desc = json_decode($row['desc']);
            foreach ($desc as $d => $det) {
                if ($d == "desc") { ?>
            <h4 class="txt w3-center"> Additional Description</h4>
            <p class="txt"><?php echo $det; ?></p>
            <?php } else { ?>
            <h4 class="txt w3-center"><?php echo "Day" . $d[strlen($d) - 1]; ?></h4>
            <br>
            <p class="txt">
                <?php echo $det; ?>
            </p>
            <br>
            <?php }
            } ?>
        </div>
    </div>
    <div class="w3-contentp">
        <div class=" w3-container">
            <h3 style="margin-top: 20px;" class="w3-center txt">Reviews</h3>
            <?php
            $sql3 = "SELECT AVG(rating) as avg, * FROM review WHERE pid = '$pid' ORDER BY rating DESC LIMIT 3";
            //echo $sql3;
            $ret3 = $db->query($sql3);
            while ($row3 = $ret3->fetchArray(SQLITE3_BOTH)) {
                if ($row3['email'] != null) {
                    $cemail = $row3['email'];
                    $sqlname = "SELECT name FROM customers WHERE email = '$cemail'";
                    $retname = $db->query($sqlname);
                    $rowname = $retname->fetchArray(SQLITE3_BOTH);
            ?>
            <?php if ($i == 0) { ?>
            <div class="w3-center">
                <h4 class="txt w3-center">Total Rating :
                    <?php for ($j = 0; $j < 5; $j++) {
                                    if (($row3['avg'] - $j) >= 1) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif (($row3['avg'] - $j) < 1 && ($row3['avg'] - $j) > 0) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                } ?>
                </h4>
            </div>
            <br>
            <?php } ?>
            <div class="w3-third w3-row-padding txt">
                <h4 class="txt w3-center"><?php echo ucwords($rowname['name']); ?></h4>
                <div class="w3-center">
                    <?php for ($j = 0; $j < 5; $j++) {
                                if (($row3['avg'] - $j) >= 1) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif (($row3['avg'] - $j) < 1 && ($row3['avg'] - $j) > 0) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            } ?>
                </div>
                <p class="txt w3-center"><?php echo $row3['description']; ?></p>
                <div class="w3-display-container w3-center">
                    <img class="img4" src="<?php echo "../rimage/" . $row3['rimage']; ?>">
                </div>
            </div>
            <?php
                }
            } ?>
        </div>
        <br>
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
    <script>
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName(" mySlides");
        if (n > x.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = x.length
        }
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x[slideIndex - 1].style.display = "block";
    }
    </script>
</body>