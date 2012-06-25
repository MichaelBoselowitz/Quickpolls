<?php
$id = $_GET["id"];
$fp = file("users.txt");
foreach($fp as $key => $value)		//Look up password for id in $_GET 
{
	$breakdown = explode(",", $value);
	if(strcmp($breakdown[0], $id) == 0)		//If id found, mail to email provided
	{
		mail($breakdown[2], "Forgotten Password for Quickpoll", "Your forgotten password is: ".$breakdown[1]);
		break;
	}
}
header("Location: memberslogin.php");		//Return to page
?>