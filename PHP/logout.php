<?php
session_start();
setcookie("loginemail", "", 1);
setcookie("loginpass", "", 1);
setcookie("name", "", 1);
setcookie("contact", "", 1);
unset($_SESSION["loginemail"]);
unset($_SESSION["loginpass"]);
unset($_SESSION["name"]);
unset($_SESSION["contact"]);
header('Refresh: 2; URL=../HTML/index.html');
echo "<h3>Logging out, redirecting to home page.</h3>";