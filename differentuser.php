<?php
$id = $_GET["id"];			//Unset cookie and return to memberslogin.php
$fp = file("users.txt");
setcookie("id", $id, time()-10);
header("Location: memberslogin.php");
?>