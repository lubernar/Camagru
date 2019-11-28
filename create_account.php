<?php
include("navbar.php");
// session_start();
function create_account()
{
	$login = $_POST["login"];
	$passwd = $_POST["passwd"];
	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$email = $_POST["email"];
	$verifPassword = $_POST["verifpasswd"];
	$token = md5(microtime(TRUE)*100000);
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
		$req = $bdd->prepare('INSERT INTO users (login, password, email, token) VALUES (:login, :passwd, :email, :token)');
		$req->execute(array('login' => $login, 'passwd' => $passwd, 'email' => $email, 'token' => $token));
		send_email($email, $login, $token);
		header("Location: http://127.0.0.1:8080");
	}
}
function send_email($email, $login, $token)
{
	$subject = "Camagru account verification";
	$message = 'Please follow this link to activate your account.
	http://localhost:8080/activation.php?log='.urlencode($login).'&token='.urlencode($token).'


	---------------
	This is an automatic mail, please do not answer it.';
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
		<section class="section">
		<div class="container">
		<div class="create_account_form">
			<form method="post" action="create_account.php" id="createForm">
			<div class="field">
			<p class="control has-icons-left has-icons-right">
				<input name="email" class="input" type="email" placeholder="Email">
				<span class="icon is-small is-left">
					<i class="fas fa-envelope"></i>
				</span>
			</p>
		</div>
		<div class="field">
			<p class="control has-icons-left has-icons-right">
				<input name="login" class="input" placeholder="Login">
				<span class="icon is-small is-left">
				 <i class="fas fa-user"></i>
				</span>
			</p>
		</div>
		<div class="field">
			<p class="control has-icons-left">
				<input name="passwd" class="input" type="password" placeholder="Password">
				<span class="icon is-small is-left">
					<i class="fas fa-lock"></i>
				</span>
			</p>
		</div>
		<div class="field">
			<p class="control has-icons-left">
				<input name="verifpasswd" class="input" type="password" placeholder="Verify password">
				<span class="icon is-small is-left">
					<i class="fas fa-lock"></i>
				</span>
			</p>
		</div>
				<button type="submit" name="create" class="button is-success">Create</button>
			</form>
	</div>
	</div>
	</section>
	</body>
</html>
