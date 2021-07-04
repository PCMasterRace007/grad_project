<?php
session_start();
setcookie("bloginemail", "", 1);
setcookie("bloginpass", "", 1);
setcookie("bname", "", 1);
setcookie("bcontact", "", 1);
unset($_SESSION["bloginemail"]);
unset($_SESSION["bloginpass"]);
unset($_SESSION["bname"]);
unset($_SESSION["bcontact"]);
header('Refresh: 2; URL=../HTML/business.html');
echo "<h3>Logging out, redirecting to home page.</h3>";