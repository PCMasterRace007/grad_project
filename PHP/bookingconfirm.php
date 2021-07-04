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
        echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
        exit();
    }
    if (!isset($_COOKIE["loginemail"])) {
        header('Refresh: 2; URL=../HTML/login.html');
        echo '<h3 class="w3-center txt">You are not logged in, please login. Redirecting you to login page</h3>';
        exit();
    }
    $email = $_COOKIE["loginemail"];
    $pid = $_POST["pid"];
    $count = $_POST["count"];
    $from = $_POST["date"];
    $dur = $_POST["dur"];
    $caccno = $_POST["accno"];
    $date = $_POST["date"];
    $tdate = date('Y-m-d', strtotime($date . "+" . (string)$dur . "days"));


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
    <?php
    $bid = $email . uniqid(rand());;
    //$ret = $db->exec($sql);
    $sql = "INSERT INTO pkg_info (
            bid,
            pid,
            fromdate,
            todate,
            approval,
            ispaid,
            caccno,
            email
        )
        VALUES (
            '$bid',
            '$pid',
            '$date',
            '$tdate',
            0,
            0,
            '$caccno',
            '$email'
        )";
    $ret = $db->exec($sql);
    if (!$ret) {
        header("Refresh: 2; URL=searchdetails.php?pid=$pid");
        echo '<h3 class="w3-center txt">Booking failed. Try again.</h3>';
        echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
        $db->close();
        exit();
    } else {
        for ($i = 1; $i <= $count; $i++) {
            $name[$i] = $_POST["name$i"];
            $age[$i] = $_POST["age$i"];
            $id[$i] = $_POST["id$i"];
            $sql2 = "INSERT INTO guest_info (
                gemail,
                name,
                age,
                bid,
                id
            )
            VALUES (
                '$email',
                '$name[$i]',
                '$age[$i]',
                '$bid',
                '$id[$i]'
            )";
            $ret2 = $db->exec($sql2);
            if (!$ret2) {
                header("Refresh: 2; URL=searchdetails.php?pid=$pid");
                echo '<h3 class="w3-center txt">Booking failed. Try again.</h3>';
                echo '<h3>Error encountered, redirecting' . $db->lastErrorMsg() . '</h3>';
                $db->close();
                exit();
            }
        }
    }
    ?>
    <div class="w3-contentp txt">
        <h3 class="w3-center txt">Proceed to payment...</h3>
        <br>
        <h3 class="w3-center txt">The booking was done. It is awaiting approval from the agency. After getting
            approved the payment must be done within 48 hours.</h3>
        <?php header("Refresh: 4; URL=searchdetails.php?pid=$pid"); ?>
    </div>
</body>