<?php
session_start();
$id = $_SESSION['id'];
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
$req = $bdd->prepare('SELECT active FROM users WHERE id = ?');
$req->execute(array($id));
$active = $req->fetch(PDO::FETCH_ASSOC);
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
		$req2 = $bdd->prepare('SELECT content, likes, creation_date FROM pictures WHERE user_id = :id');
		$req2->execute(array('id' => $id));
		$content = $req2->fetchAll(PDO::FETCH_ASSOC);
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
		?>
		</div>

	</body>
</html>
