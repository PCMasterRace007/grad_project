<?php
session_start();
$email = $_COOKIE["bloginemail"];
$bid = $_POST["bid"];
$target_dir = "../payimage/";
$fname = $bid . "." . strtolower(pathinfo($_FILES["proof"]["name"], PATHINFO_EXTENSION));
$target_file = $target_dir . $fname;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["upload"])) {
    $check = getimagesize($_FILES["proof"]["tmp_name"]);
    if ($check !== false) {
        echo "<h3>File is an image - " . $check["mime"] . ".</h3>";
        $uploadOk = 1;
    } else {
        header("Refresh: 2; URL=showbooking.php?bid=$bid");
        echo '<h3>File is not an image. Redirecting you to your account. Please try again.</h3>';
        $uploadOk = 0;
        $db->close();
        exit();
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3>Sorry same file/picture already exists. Redirecting you to your account. Please try again with a different name.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Check file size
if ($_FILES["proof"]["size"] > 1048576) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3>Sorry your file/picture is too large in size. Redirecting you to your account. Please try again with an image of size less than 1 MB.</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
) {
    header("Refresh: 2; URL=showbooking.php?bid=$bid");
    echo '<h3>Sorry, only JPG, JPEG, PNG files are allowed. Redirecting you to your account. Please try again with an image of the above file extensions</h3>';
    $uploadOk = 0;
    $db->close();
    exit();
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo '<h3>Sorry, your file was not uploaded.</h3>';
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
        header("Refresh: 2; URL=showbooking.php?bid=$bid");
        echo "<h3>The file " . htmlspecialchars(basename($_FILES["proof"]["name"])) . " has been uploaded.</h3><h3>Your profile picture was successfully changed, redirecting you to your account";
    } else {
        echo '<h3>Sorry, there was an error uploading your file.</h3>';
    }
}
$db->close();
exit();