<?php
session_start();
// include("bd_connection.php");
// if ($_SESSION['login']!== "")
// {
// 	$is_admin = "SELECT admin_id FROM client WHERE '$_SESSION[login]' = login";
// 	$result = $conn->query($is_admin);
// 	$row = $result->fetch_assoc();
// }
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<link rel="stylesheet" href="style.css">
		</head>
		<body>
		<title>Camagru</title>
		<div class="header">
		<a href="index.php"><h1>Camagru</h1></a>
		<?php
		if ($_SESSION['login'] == "")
		{

			echo"
			<form class=\"loginForm\" method=\"post\" action=\"login.php\" id=\"connectForm\">
			<h7>Login:</h7><br>
			<input type=\"text\" name=\"login\"><br>
			<h7>Password:<br>
			</h7> <input type=\"password\" name=\"passwd\"><br><br>
			<input type=\"submit\" value=\"Connect\" name=\"connect\"><br>
			<a class=\"createAccount\" href=\"create_account.php\">Create account</a>
			</form>";
		}
		else
		{

			echo "<p style=\"color: blanchedalmond;;\">Hello " . $_SESSION['login'] . "</br></br></p>";
			echo "<a href=\"logout.php\" style=\"
			float: right; margin-right: 2vw;\">Logout</a><br>";
			echo "<a href=\"modify_account.php\" style=\"
			float: right; margin-right: 2vw;\">Modify account</a>";
		}
		?>
		</div>
	</body>
</html>
