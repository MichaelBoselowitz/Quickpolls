<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php $title = explode(",", $_POST["choice"]); echo $title[1];  ?></title>
</head>

<body>
<a href="quickpoll.php">Home</a>
<br />
<br />
<?php
if(isset($_POST["choice"]))
{
	$tmp = explode(".", $_POST["choice"]);
	$post = explode(",", $tmp[0]);
	$questionskey = $tmp[1];
	echo "Results for ".$post[1]."<br />";
	if($post[2] == 1)	//Update variable if poll is open
	{
		$questions = explode("|", $post[4]);		//Update the variable in question
		$q = explode("^", $questions[$questionskey]);
		$q[1]++;
		$questions[$questionskey] = implode("^", $q);	//Put it back together
		$tmp = implode("|", $questions);
		$post[4] = $tmp;
		$fp = file("polls.txt");	//Open file
		foreach($fp as $key => $value)	//Go through file and find the entry in question
		{
			$poll = explode(",", $value);
			if(strcmp($poll[0], $post[0]) == 0 && strcmp($poll[1], $post[1]) == 0)		//If found the poll in the file, update file to show the update
			{
				$fp[$key] = implode(",", $post)."\n";
				break;
			}
		}
		file_put_contents("polls.txt", $fp);	//Write out the entire contents
	}
	//Now show the results in a well formed table
	echo "<table><tr><th>";
	echo $post[3];
	echo "</th></tr>";
	$questions = explode("|", $post[4]);
	foreach($questions as $key => $value)
	{
		$q = explode("^", $value);
		echo "<tr><td>".$q[0]."</td><td>".$q[1]."</td></tr>";
	}
	echo "</table>";
}
else	//No selection made
{
	echo "Error: Please go back and make a selection";
}
?>
</body>
</html>