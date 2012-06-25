<?php
session_start();	//Start session
if(isset($_SESSION["active"]))	//If session exists open it
	$active = $_SESSION['active'];
if(isset($_COOKIE["id"]))	//If cookie exists open it
	$id = $_COOKIE['id'];
if(isset($_POST["user"]))	//Received post, aka a form to be processed
{
	if(isset($_POST["newuser"]))	//New user
	{
		if(strcmp($_POST["user"], "") == 0 || strcmp($_POST["password"], "") == 0 || strcmp($_POST["email"], "") == 0)		//Make sure there isn't null input
		{
			show_header();
			show_newlogin("Error: Please enter non null values");	//Show the error
			end_page();
		}
		else
		{		//My regex for finding commas for user entry does not work
		
			/*if(preg_split("/[,]+/", $_POST["user"]) || preg_split("/[,]+/", $_POST["password"]) || preg_split("/[,]+/", $_POST["email"]))
			{
				show_header();
				show_newlogin("Error: Special character in user name, password, or email".(int)preg_split('/[\,]+/','ajakl').(int)preg_split("/[,]/", $_POST["password"]).(int)preg_split("/[,]/", $_POST["email"]));
				end_page();
			}
			else
			{*/
				$found = false;
				$fp = fopen("users.txt", "a+");
				while($input = fgetss($fp))		//Look for entry to make sure it doesn't exist already
				{
					$breakdown = explode(",", $input);
					if(strcmp($breakdown[0], $_POST["user"]) == 0)	//If found break and set to true
					{
						$found = true; 
						break;
					}
				}
				if(!$found)		//If there was no other user entry append one
				{
					fwrite($fp, $_POST["user"].",".$_POST["password"].",".$_POST["email"]."\n");
					fclose($fp);
					setcookie("id", $_POST["user"], time()+(30 * 24 * 60 * 60));	//30 day cookie
					$_SESSION['active'] = true;		//Set the session
					header("Location: members.php");	//Throw to members page
				}
				else	//User name found, show error
				{
					show_header();
					show_newlogin("Error: User name taken, choose another");
					end_page();
				}
			}
		//}
	}
	else if(!isset($id) || !isset($active))	//No id or no session
	{
		$founduser = false;
		$userfile = file("users.txt");
		foreach($userfile as $key => $value)	//search user file for user
		{
			$breakdown = explode(",", $value);
			if(strcmp($breakdown[0], $_POST["user"]) == 0)	//Found user name
			{
				$founduser = true;
				if(strcmp($breakdown[1], $_POST["password"]) == 0)	//Right password
				{
					if(!isset($id))
						setcookie("id", $_POST["user"], time()+(30 * 24 * 60 * 60));	//30 day cookie
					if(!isset($session))
						$_SESSION["active"] = true;
					header("Location: members.php");		//Kick to members.php
				}
				else	//Wrong password, show login and alert user
				{
					if(!isset($id))
						setcookie("id", $_POST["user"], time()+(30 * 24 * 60 * 60));	//30 day cookie
					show_header();
					show_regularlogin("Wrong password!");
					end_page();
				}
				break;
			}
		}
		if(!$founduser)		//Didn't find user, show login page again.
		{
			show_header();
			show_newlogin("User doesn't exist!");
			end_page();
		}
	}
}
else	//No form, must be just viewing the page
{
	if(!isset($id))		//New user or returning user with deleted cookie
	{
		show_header();
		show_newlogin("");
		end_page();
	}
	else
	{
		if(!isset($active))		//Somebody has to just login
		{
			show_header();
			show_regularlogin("");
			end_page();
		}
		else	//Alread logged in send to members.php
		{
			header("Location: members.php");
		}
	}
}
function show_header()		//Basic header
{
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Member's Page Login</title>
    </head>
    <?php
}
function show_newlogin($error)		//Page for new user login
{
	?>
    <body>
    <a href="quickpoll.php">Home</a>
    <br />
    <br />
	<?php
    if(isset($error))	//Show error
    	 echo $error; ?>
    <form action="memberslogin.php" method="POST">
    Username: <input type="text" name="user" />
    <br />
    Password: <input type="password" name="password" />
    <br />
    Email: <input type="text" name="email" />
    <br />
    New User? <input type="checkbox" name="newuser" value="newuser" />
    <br />
    <input type="submit" value="Submit" />
    </form>
    </body>
    <?php
}
function show_regularlogin($error)
{
	?>
	<body>
    <a href="quickpoll.php">Home</a>
    <br />
    <br />
    <?php //Show welcome message
		if(isset($_COOKIE["id"]))		//Should be set, but because of cookie propgation might not be
			echo "Hello, ".$_COOKIE['id']." welcome back!";
		else
			echo "Hello, welcome back!";?>
    <br />
    <?php 
	if(isset($error))	//Show error
		echo $error; ?>
    <form action="memberslogin.php" method="POST">
    Username: <input type="text" name="user" value="
	<?php if(isset($_COOKIE["id"]))		//If there is a cookie auto fill username
			echo $_COOKIE['id'] ?>" />
    <br />
    Password: <input type="password" name="password" />
    <br />
    <input type="submit" value="Submit" />
    </form>
    <a href="forgetpassword.php?id=<?php echo $_COOKIE['id']; ?>">Forgot Password</a>
    <br />
    <a href="differentuser.php?id=<?php echo $_COOKIE['id']; ?>">Different User</a>
    </body>
    <?php
}
function end_page()
{
	?>
	</html>
    <?php
}
?>