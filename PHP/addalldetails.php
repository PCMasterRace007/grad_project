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
    header('Refresh: 2; URL=addlisting.php');
    echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
    exit();
}
//data
$email = $_COOKIE["bloginemail"];
$name = $_POST["name"];
$dest = $_POST["dest"];
$dur = $_POST["dur"];
$cost = $_POST["cost"];
//place
for ($i = 1, $j = 0; $i <= 8; $i++) {
    $n = "p" . (string)$i;
    if (!($_POST["$n"]) == "") {
        $place[$j] = $_POST["$n"];
        $j++;
    }
}
$places = implode(", ", $place);
//search tags
for ($i = 1, $j = 0; $i <= 4; $i++) {
    $n = "p" . (string)$i;
    if (!($_POST["$n"]) == "") {
        $stag[$j] = $_POST["$n"];
        $j++;
    }
}
//echo $places . "<br>";
$food = $_POST["food"];
$travel = $_POST["travel"];
if ($travel == 1) {
    $ttype = "Air";
} else {
    $ttype = "Land";
}
//route
for ($i = 1, $j = 0; $i <= 4; $i++) {
    $n = "r" . (string)$i;
    if (!($_POST["$n"]) == "") {
        $route[$j] = $_POST["$n"];
        $j++;
    }
}
$routes = implode(", ", $route);
//echo $routes . "<br>";
//activities
for ($i = 1, $j = 0; $i <= 4; $i++) {
    $n = "a" . (string)$i;
    if (!($_POST["$n"]) == "") {
        $activity[$j] = $_POST["$n"];
        $j++;
    }
}
$activities = implode(", ", $activity);
//echo $activities . "<br>";
for ($i = 1, $j = 0; $i <= $dur; $i++) {
    $n = "d" . (string)$i;
    $DESC["$n"] = $_POST["$n"];
}
$desc = $_POST["desc"];
$DESC["desc"] = $_POST["desc"] . "<br>";
$DJSON = json_encode($DESC, JSON_HEX_APOS);
//echo $DJSON . "<br>";
$islisted = $_POST["islisted"];
$pid = $email . uniqid(rand());

$sql = "INSERT INTO packages (
    pid,
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
)
VALUES (
    '$pid',
    '$name',
    '$dest',
     $dur,
     $cost,
    '$places',
    $food,
    '$ttype',
    '$routes',
    '$activities',
    '$DJSON',
    $islisted,
    '$email',
    '$stag[0]',
    '$stag[1]',
    '$stag[2]',
    '$stag[3]'
)";
//images
$target_dir = "../pacimage/";
$i = 0;
for ($i = 0; $i < 4; $i++) {
    $n = "pic" . (string)$i;
    $fname[$i] = $email . basename($_FILES["$n"]["name"]);
    $target_file[$i] = $target_dir . $fname[$i];
    $uploadOk[$i] = 1;
    $imageFileType[$i] = strtolower(pathinfo($target_file[$i], PATHINFO_EXTENSION));
    //echo $target_file[$i];
    //echo "<br>";
}
// Check if image file is a actual image or fake image
for ($i = 0; $i < 4; $i++) {
    if (isset($_POST["upload"])) {
        $n = "pic" . (string)$i;
        $check[$i] = getimagesize($_FILES["$n"]["tmp_name"]);
        if ($check[$i] !== false) {
            echo "<h3>File " . (string)($i + 1) . " is an image - " . $check[$i]["mime"] . ".</h3>";
            //$uploadOk = 1;
        } else {
            //header('Refresh: 2; URL=addlisting.php');
            echo "<h3>Image number " . (string)($i + 1) . " is not an image.</h3>";
            echo '<h3>Sorry, only JPG, JPEG, PNG files are allowed. </h3> Redirecting you to your account. Please try again.';
            $uploadOk[$i] = 0;
            $db->close();
            exit();
        }
    }
}
for ($i = 0; $i < 4; $i++) {
    if (file_exists($target_file[$i])) {
        //header('Refresh: 2; URL=addlisting.php');
        echo '<h3>Sorry same file/picture name already exists for file ' . (string)($i + 1) . '. Redirecting you to your account. Please try again with a different name.</h3>';
        $uploadOk[$i] = 0;
        $db->close();
        exit();
    }
}
// Check file size
for ($i = 0; $i < 4; $i++) {
    $n = "pic" . (string)$i;
    if ($_FILES["$n"]["size"] > 1048576) {
        //header('Refresh: 2; URL=addlisting.php');
        echo '<h3>Sorry picture ' . (string)($i + 1) . ' is too large in size. Redirecting you to your account. Please try again with an image of size less than 1 MB.</h3>';
        $uploadOk[$i] = 0;
        $db->close();
        exit();
    }
}
// Allow certain file formats
for ($i = 0; $i < 4; $i++) {
    if ($imageFileType[$i] != "jpg" && $imageFileType[$i] != "png" &&       $imageFileType[$i] != "jpeg") {
        //header('Refresh: 2; URL=addlisting.php.php');
        echo "<h3>Image " . (string)$i . " is not an appropriate image file type</h3>";
        echo '<h3>Sorry, only JPG, JPEG, PNG files are allowed. Redirecting you to your account. Please try again with an image of the above file extensions</h3>';
        $uploadOk[$i] = 0;
        $db->close();
        exit();
    }
}

//Check if $uploadOk is set to 0 by an error
for ($i = 0; $i < 4; $i++) {
    if ($uploadOk[$i] == 0) {
        //header('Refresh: 2; URL=addlisting.php.php');
        echo '<h3>Sorry, your image files were not uploaded. There was an error. You will be redirected to form page. Try again.</h3>';
        echo $uploadOk[$i] . "<br>";
        $db->close();
        exit();
    }
}
// if everything is ok, try to upload file and data
for ($i = 0; $i < 4; $i++) {
    $n = "pic" . (string)$i;
    echo $n . "<br>";
    if (move_uploaded_file($_FILES["$n"]["tmp_name"], $target_file[$i])) {
        echo "<h3>The file " . htmlspecialchars(basename($_FILES["$n"]["name"])) . " has been uploaded to your package.</h3>";
        //Deleting previous user image
        /*$email = $_COOKIE["loginemail"];
    $sqlp = "SELECT pimage FROM customers WHERE email = '$email'";
    $retp = $db->query($sqlp);
    if (($rowp = $retp->fetchArray(SQLITE3_BOTH))) {
        $dimage = $target_dir . $rowp['pimage'];
        unlink("$dimage");
    }*/
        $sql2 = "INSERT INTO pacimage (
        pid,
        image
        )
        VALUES (
        '$pid',
        '$fname[$i]'
        )";
        $ret2 = $db->exec($sql2);
        if (!$ret2) {
            echo "<h3>" . $db->lastErrorMsg() . "</h3>";
        } else {
            echo "<h3>Image" . (string)($i + 1) . "was uploaded for your package</h3>";
        }
    } else {
        //header('Refresh: 2; URL=addlisting.php');
        echo '<h3>Sorry, there was an error uploading your file.</h3>';
        $sql3 = "DELETE FROM pacimage
        WHERE pid = '$pid'";
        $ret3 = $db->exec($sql3);
        if (!$ret3) {
            echo "<h3>" . $db->lastErrorMsg() . "</h3>";
        } else {
            echo "<h3>Residual images cleaned</h3>";
        }
        exit();
    }
}
$ret = $db->exec($sql);
echo $sql . "<br>";
echo $DJSON . "<br>";
print_r(json_decode($DJSON, true)) . "<br>";
if (!$ret) {
    echo "<h3>" . $db->lastErrorMsg() . "</h3>";
    $sql3 = "DELETE FROM pacimage
        WHERE pid = '$pid'";
    $ret3 = $db->exec($sql3);
    if (!$ret3) {
        echo "<h3>" . $db->lastErrorMsg() . "</h3>";
    } else {
        //header('Refresh: 2; URL=bsettings.php');
        echo "<h3>Residual images cleaned. You will be redirected.</h3>";
    }
} else {
    //header('Refresh: 2; URL=bsettings.php');
    echo "<h3>Your package was uploaded successfully. You will be redirected to your profile.</h3>";
}
$db->close();
exit();