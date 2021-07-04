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
$email = $_COOKIE["bloginemail"];
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
$sql2 = "SELECT
image
FROM pacimage
WHERE pid = '$pid'";
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

    <div class="w3-card-4 w3-round">
        <div class="w3-container">
            <h3 class="w3-center txt">Listing ID: <?php echo $_GET["pid"]; ?></h3>
            <br>
            <h4 class="w3-center txt">Details</h4>
        </div>
        <br>
        <?php
        $ret = $db->query($sql);
        if (!$ret) {
            header('Refresh: 2; URL=bsettings.php');
            echo "<h4>Error encountered. Redirecting to your profile. Try again.";
        } else {
            $n = $ret->numColumns();
            $row = $ret->fetchArray(SQLITE3_BOTH);
        ?>
        <div class="w3-responsive">
            <table class="w3-table-all">
                <tr class="w3-fc txtb">
                    <?php
                        for ($i = 0; $i < $n; $i++) { ?>
                    <th>
                        <?php
                                $name = $ret->columnName($i);
                                if ($name == 'pid') {
                                    echo "Package ID";
                                }
                                if ($name == 'name') {
                                    echo "Name";
                                }
                                if ($name == 'dest') {
                                    echo "Destination";
                                }
                                if ($name == 'cost') {
                                    echo "Cost";
                                }
                                if ($name == 'places') {
                                    echo "Visiting Places";
                                }
                                if ($name == 'food') {
                                    echo "Fooding included ?";
                                }
                                if ($name == 'ttype') {
                                    echo "Travel Type";
                                }
                                if ($name == 'route') {
                                    echo "Route taken";
                                }
                                if ($name == 'activities') {
                                    echo "Activities included";
                                }
                                if ($name == 'islisted') {
                                    echo "Is this package listed ?";
                                }
                                if ($name == 'bemail') {
                                    echo "Linked email";
                                }
                                if ($name == 'desc') {
                                    continue;
                                    //dont list description here
                                }
                                ?>
                    </th>
                    <?php
                        } ?>

                </tr>

                <tr class="txt">
                    <?php
                        for ($i = 0; $i < $n; $i++) { ?>
                    <td>
                        <?php
                                $name = $ret->columnName($i);
                                if ($row[$i] === 1) {
                                    echo "Yes";
                                } elseif ($row[$i] === 0) {
                                    echo "No";
                                } else {
                                    if ($name == 'desc') {
                                        //skip description
                                        continue;
                                    } else {
                                        echo $row[$i];
                                    }
                                }


                                ?>
                    </td>
                    <?php
                        } ?>
                </tr>
            </table>
        </div>

        <?php }
        ?>
        <br>
        <div class="w3-container">
            <h4 class="w3-center txt">Description</h4>
        </div>
        <br>
    </div>
    <div class="w3-responsive">
        <table class="w3-table-all">
            <tr class="w3-fc txtb">

                <?php
                $desc = json_decode($row['desc']);
                foreach ($desc as $d => $det) { ?>
                <td>
                    <?php
                        if ($d == "desc") {
                            echo "Description";
                        } else {
                            echo "Day" . $d[strlen($d) - 1];
                        }
                        ?>
                </td>
                <?php } ?>

            </tr>
            <tr class="txt">
                <?php
                foreach ($desc as $d => $det) { ?>
                <td>
                    <p class="para">
                        <?php echo $det; ?>
                    </p>
                </td>
                <?php } ?>
            </tr>
        </table>
        <br>

    </div>
    <div class="w3-container">
        <h4 class="w3-center txt">Images</h4>
    </div>
    <br>
    <div class="w3-row-padding w3-margin-top txt">
        <?php
        $ret2 = $db->query($sql2);
        ?>
        <div class="w3-quarter">
            <div class="w3-card">
                <img class="img" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                        echo "../pacimage/" . $p1['image']; ?>" style="width:100%">
                <div class="w3-container">
                    <h4 class="txt">Image 1</h4>
                </div>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card">
                <img class="img" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                        echo "../pacimage/" . $p1['image']; ?>" style="width:100%">
                <div class="w3-container">
                    <h4 class="txt">Image 2</h4>
                </div>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card">
                <img class="img" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                        echo "../pacimage/" . $p1['image']; ?>" style="width:100%">
                <div class="w3-container">
                    <h4 class="txt">Image 3</h4>
                </div>
            </div>
        </div>
        <div class="w3-quarter">
            <div class="w3-card">
                <img class="img" src="<?php $p1 = $ret2->fetchArray(SQLITE3_BOTH);
                                        echo "../pacimage/" . $p1['image']; ?>" style="width:100%">
                <div class="w3-container">
                    <h4 class="txt">Image 4</h4>
                </div>
            </div>
        </div>
    </div>

    <br>
</body>