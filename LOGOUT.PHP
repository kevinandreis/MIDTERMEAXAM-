<link rel="stylesheet" href="reglogout.css">

<?php
require_once 'models.php';
logoutUser();
header("Location: login.php");
exit();
?>
