<?php
session_start();
setcookie("username");
$_SESSION['username'] = '';
header("Location: /index.php");
session_destroy();
exit();