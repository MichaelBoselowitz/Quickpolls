<?php
session_start();	//Start session
$active = $_SESSION['active'];
$id = $_COOKIE['id'];
if(!isset($active) || !isset($id))		//If not suppose to be on members page kick out to members login
{
	header("Location: memberslogin.php");
}
else
{
	if(isset($_POST["submit"]))		//if there was a submission run through what it could be and act accordingly
	{
		if(strcmp($_POST["submit"], "Toggle Status") == 0)		//If it was a toggle status
		{
			$post = explode(",", $_POST["choice"]);
			$fp = file("polls.txt");
			foreach($fp as $key => $value)		//Find poll that's status changed and update.
			{
				$poll = explode(",", $value);
				if(strcmp($poll[0], $post[0]) == 0 && strcmp($poll[1], $post[1]) == 0)		//Flip it if you find it
				{
					if($post[2] == 0)
						$poll[2] = 1;
					else if($post[2] == 1)
						$poll[2] = 0;
					$fp[$key] = implode(",", $poll);
					break;
				}
			}
			file_put_contents("polls.txt", $fp);	//Write back and show the regular page
			show_header();
			show_body();
		}
		else if(strcmp($_POST["submit"], "Delete") == 0)	//On delete
		{
			$post = explode(",", $_POST["choice"]);
			$fp = file("polls.txt");
			foreach($fp as $key => $value)		//Find poll in file and delete line
			{
				$poll = explode(",", $value);
				if(strcmp($poll[0], $post[0]) == 0 && strcmp($poll[1], $post[1]) == 0)
				{
					$fp[$key] = "";
					break;
				}
			}
			file_put_contents("polls.txt", $fp);	//Write and show regular page
			show_header();
			show_body();
		}
		else if(strcmp($_POST["submit"], "Create Poll") == 0)	//Create poll, show a poll creation form
		{
			show_header();
			show_edit_body();
		}
		else if(strcmp($_POST["submit"], "Logout") == 0)	//Log out, kill the session.
		{
			session_destroy();
			header("Location: quickpoll.php");
		}
	}
	else		//If no submission just show the page
	{
		show_header();
		show_body();
	}
}
function show_header()		//Basic header
{
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Member's Page</title>
    </head>
    <?php
}
function show_body()	//Show body with form of what you can do
{
    echo "<body>";
    echo "<a href='quickpoll.php'>Home</a>";
    echo "<br /><br />";
    $fp = fopen("polls.txt", "r");
    echo "<form action='members.php' method='POST'>";
	echo "<table><tr><th>Selection</th><th>Name</th><th>Status</th></tr>";	//Show table of all polls owned by the user
    while($poll = fgetss($fp))
    {
        $pollstr = explode(",", $poll);
        if(strcmp($pollstr[0], $_COOKIE["id"]) == 0)
        {
            echo "<tr><td><input type='radio' name='choice' value='".$poll."' /></td><td>";		//Radio button shown for each poll
            echo $pollstr[1];
			if($pollstr[2] == 1)
				echo "</td><td>Open</td></tr>";
			else
				echo "</td><td>Closed</td></tr>";
        }
    }
    fclose($fp);
	echo "</table>";
	echo "<br />";			//Show buttons
	echo "<table><tr><td><input type='submit' name='submit' value='Toggle Status' /></td><td><input type='submit' name='submit' value='Delete' /></td></tr>";
	echo "<tr><td><input type='submit' name='submit' value='Create Poll' /></td><td><input type='submit' name='submit' value='Logout' /></td></tr></table>";
	echo "</form>";
    echo "</body>";
	echo "</html>";
}
function show_edit_body()	//Edit body is the form for creating a poll and then pass to editpoll.php for rest of form
{
	echo "<body>";
    echo "<a href='quickpoll.php'>Home</a>";
    echo "<br /><br />";
    echo "<form action='editpoll.php' method='POST'>";
	echo "Subject: <input type='text' name='subject' />";
	echo "<br />";
	echo "Question: <input type='text' name='question' />";
	echo "<br />";
	echo "Number of Answers: <input type='text' name='answers' />";
	echo "<br />";
	echo "<input type='submit' value='Submit' />";
	echo "</form>";
    echo "</body>";
	echo "</html>";
}
?>