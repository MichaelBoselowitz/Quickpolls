<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Quick Poll</title>
</head>

<body>
<a href="quickpoll.php">Welcome to Quickpolls!</a>
<br />
<br />
Active Polls:
<br />
<?php
$fp = fopen("polls.txt", "r");	//Form, for choosing active quick poll
echo "<form action='poll.php' method='POST'>";	//Using post
while($poll = fgetss($fp))	//Iterate through polls.txt looking for open polls to post as radio buttons
{
	$pollstr = explode(",", $poll);
	if($pollstr[2] == 1)
	{
		echo "<input type='radio' name='choice' value='".$poll."' />";	//value is equal to the poll.txt entry
		echo $pollstr[1];
		echo "<br />";	
	}
}
fclose($fp);
echo "<input type='submit' value='Submit' />";
echo "</form>"
?>
<br />
<a href="closedpolls.php">Closed Polls</a>
<br />
<a href="memberslogin.php">Members Page</a>
</body>
</body>
</html>