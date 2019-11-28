
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<link rel="stylesheet" href="style.css">
</head>
<body>


</body>
</html>
<?php
include("navbar.php");
if ($_SESSION['login'] == "")
		{
			echo"
			<section class=\"section\">
			<div class=\"container\">";
			echo"
			<form class=\"loginForm\" method=\"post\" action=\"login.php\" id=\"connectForm\">
			<div class=\"field\">
			<p class=\"control has-icons-left has-icons-right\">
				<input name=\"login\" class=\"input\" placeholder=\"Login\">
				<span class=\"icon is-small is-left\">
				 <i class=\"fas fa-user\"></i>
				</span>
			</p>
			</div>
			<div class=\"field\">
			<p class=\"control has-icons-left\">
				<input name=\"passwd\" class=\"input\" type=\"password\" placeholder=\"Password\">
				<span class=\"icon is-small is-left\">
					<i class=\"fas fa-lock\"></i>
				</span>
			</p>
		</div>
			<button name=\"connect\" type=\"submit\" class=\"button is-success is-light\">Connect</button>
			<br><a class=\"createAccount\" href=\"create_account.php\">Create account</a>
			</form>
			</div>
			</section>";
		}
		else
		{
			echo "<section class=\"section\">
			<div class=\"container\">";
			echo "<p style=\"color: blanchedalmond;;\">Hello " . $_SESSION['login'] . "</br></br></p>";
			if ($_SESSION['login'] != "")
			{
				echo "
				<a href=\"webcam.php\"><center><button class=\"button is-dark\">My gallery</button></center></a>";
			}
			if ($active['active'] != 1)
			{
				echo "Your account is not verified yet, please check your mail";
			}
			echo "<a href=\"logout.php\" style=\"
			float: right; margin-right: 2vw;\">Logout</a><br>";
			echo "<a href=\"modify_account.php\" style=\"
			float: right; margin-right: 2vw;\">Modify account</a>
			</div>
			</section>";
		}
$boolLogin = false;
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
$req = $bdd->prepare('SELECT login, password, id FROM users WHERE login = ?');
$login = $_POST["login"];
$passwd = $_POST["passwd"];
$req->execute(array($login));
$users = $req->fetch(PDO::FETCH_ASSOC);
if (isset($_POST['connect']))
{
	if(!$login === "" || $passwd === "")
	{
		echo "Login or password incorrect.";
		return ;
	}
	if ($users["login"] == $login && $users["password"] == hash('whirlpool', $passwd))
		$boolLogin = true;
	if ($boolLogin)
	{
		$_SESSION['login'] = $login;
		$_SESSION['id'] = $users["id"];
	}
	else
		echo "Login or password incorrect.";
	header("Location: index.php");
}
?>
