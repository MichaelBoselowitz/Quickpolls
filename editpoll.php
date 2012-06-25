<?php
session_start();	//Start session
$active = $_SESSION['active'];
$id = $_COOKIE['id'];
if(!isset($active) || !isset($id))
{
	header("Location: memberslogin.php");
}
else if(!isset($_POST[0]))	//Not set, just show form for inputting 
{
	show_header();
	show_body();
}
else		//Received form, process
{
	for($i=0; isset($_POST[$i]); $i++)		//Put questions together
		$questions[$i] = $_POST[$i]."^0";
		
	//Once again couldn't get the regx to work
	
	/*if(preg_split("/[,^|]/", $_COOKIE["id"]) || preg_split("/[,^|]/", $_GET["subject"]) || preg_split("/[,^|]/", implode("|", $questions)))
	{
		show_header();
		echo "<body><a href='members.php'>Back</a><br />Error: Poll has special character in it</body></html>";
	}
	else
	{*/
		$found = false;
		$fp = fopen("polls.txt", "a+");
		while($input = fgetss($fp))		//Make sure there is not a poll already existance with the same subject and id
		{
			$breakdown = explode(",", $input);
			if(strcmp($breakdown[0], $_COOKIE["id"]) == 0 && strcmp($breakdown[1], $_GET["subject"]) == 0)
			{
				$found = true; 
				break;
			}
		}
		if(!$found)		//If there is not another poll in existence append to file
		{
			fwrite($fp, implode(",", array($_COOKIE["id"], $_GET["subject"], "1", $_GET["question"], implode("|", $questions)))."\n");
			header("Location: members.php");	//Show members page again
		}
		else	//Found poll, show error
		{
			show_header();
			echo "<body><a href='members.php'>Back</a><br />Error: You already created a poll that has the same subject</body></html>";
		}
	//}
}
function show_header()	//Simple header
{
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Edit Poll</title>
    </head>
    <?php
}
function show_body()	//Simple form for question input
{
	echo "<body>";
	echo $_POST["subject"];
	echo "<br />";
	echo $_POST["question"];
	echo "<br />";
	echo "<form method='POST' action='editpoll.php?subject=".$_POST["subject"]."&question=".$_POST["question"]."'>";
	for($i=0; $i<$_POST["answers"]; $i++)
		echo ($i+1).".) <input type='text' name='$i' /><br />";
	echo "<input type='submit' value='Submit' /></form>";
	echo "</body>";
	echo "</html>";
}
?>