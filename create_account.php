<?php
function create_account()
{
	$login = $_POST["login"];
	$passwd = $_POST["passwd"];
	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$email = $_POST["email"];
	$verifPassword = $_POST["verifPasswd"];
	if (isset($_POST['create']))
	{
		if (!$login === "" || $passwd === "" || $verifPassword === "")
		{
			echo "Please complete all informations.";
			return ;
		}
		if ($passwd != $verifPassword)
		{
			echo "Error, passwords are not the same.";
			return ;
		}
		$passwd = hash('whirlpool', $passwd);
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		$req = $bdd->prepare('INSERT INTO users (login, password, email) VALUES (:login, :passwd, :email)');
		$req->execute(array('login' => $login, 'passwd' => $passwd, 'email' => $email));
		send_email($email);
		header("Location: http://127.0.0.1:8080");
	}
}
function send_email($email)
{
	$subject = "Camagru account verification";
	$message = "Please follow this link to activate your account.";
	mail($email,$subject,$message);
}

if (isset($_POST['create']))
	create_account();
	?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  		<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
		<title>Create account</title>
	</head>
	<body>
		<div class="headerC">
		<a href="index.php"><h1>Camagru</h1></a>
		</div>
		<div class="create_account_form">
			<form method="post" action="create_account.php" id="createForm">
				Email:<br>
				<input type="text" name="email"><br>
				Login:<br>
				<input type="text" name="login"><br>
				Password:<br>
				<input type="password" name="passwd"><br>
				Verify password:<br>
				<input type="password" name="verifPasswd"><br>
				<input type="submit" value="Create account" name="create">
			</form>
	</div>
	</body>
</html>
