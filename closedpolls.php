<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Closed Polls</title>
</head>

<body>
<a href="quickpoll.php">Home</a>
<br />
<br />
<?php
$fp = fopen("polls.txt", "r");
echo "<form action='resultpoll.php' method='POST'>";	//resultpoll.php only allows viewing, not polling
while($poll = fgetss($fp))		//Read all polls and post any that are closed.
{
	$pollstr = explode(",", $poll);
	if($pollstr[2] == 0)		//If closed show and allow user to select poll to view only
	{
		echo "<input type='radio' name='choice' value='".$poll.".0' />";	//bogus key, won't use it anyway
		echo $pollstr[1];
		echo "<br />";	
	}
}
fclose($fp);
echo "<input type='submit' value='Submit' />";
echo "</form>"
?>
</body>
</html>
