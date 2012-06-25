<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php $title = explode(",", $_POST["choice"]); echo $title[1]; ?></title>
</head>
 
<body>
<a href="quickpoll.php">Home</a>
<br />
<?php 
if(isset($_POST["choice"]))		//Show poll and options, let the user vote
{	
	$post = explode(",", $_POST["choice"]);
	echo "<br />";
	if($post[2] == 1)
	{
		echo $post[3]."<br />";
		echo "<form action='resultpoll.php' method='POST'>";
		$questions = explode("|", $post[4]);
		foreach($questions as $key => $value)
		{
			$q = explode("^", $value);
			echo "<input type='radio' name='choice' value='".$_POST["choice"].".".$key."' />".$q[0];	//Use key to show which one the user picked in the array of questions
			echo "<br />";
		}
		echo "<input type='submit' value='Submit' /></form>";
	}
}
else	//Show error if no choice was made
{
	echo "Error: Please go back and make a selection";
}
?>
</body>
</html>