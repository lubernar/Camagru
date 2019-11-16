<?php
session_start();
include("bd_connection.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  		<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
		<link rel="stylesheet" href="style.css">
		<title>Modify account</title>
		<div class="headerC">
		<a href="index.php"><h1>Camagru</h1></a>
		</div>
	</head>
	<body>
		<form method="post" action="modify_account.php" id="modifyForm">
			<input class="input is-success" type="password" placeholder="Modify password" name="modif_passwd">
			<input class="input is-success" type="password" placeholder="Verify password" name="verif_passwd">
			<input class="input is-success" type="text" placeholder="Modify email" name="verif_passwd">
			<button type="submit" name="modify" class="button is-success is-light">Modify account</button>
			<button type="sumit" name="supprimer" style="float: right;" class="button is-danger">Supprimer mon compte</button>
		</form>
	</body>
</html>
<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
$passwd = hash('whirlpool', $_POST['modif_passwd']);
$verif_passwd = hash('whirlpool', $_POST['verif_passwd']);
$email = $_POST['modif_email'];
$sess_login = $_SESSION['login'];
if (isset($_POST['modify']))
{
	if ($nom !== "" && $passwd == $verif_passwd)
	{
		$req = $bdd->prepare('UPDATE users SET `password`=:passwd WHERE `login`=:sess_login');
		$req->execute(array('passwd' => $passwd,'sess_login' => $sess_login));
	}
	else
		echo "Error, passwords are not the same";
	if ($email !== "")
	{
		$req = $bdd->prepare('UPDATE users SET `email`=:email WHERE `login`=:sess_login');
		$req->execute(array('email' => $email,'sess_login' => $sess_login));
	}
}
if (isset($_POST['supprimer']))
{
	$sess_id = $_SESSION['id'];
	$req = $bdd->prepare("DELETE FROM `users`WHERE `id`=:sess_id");
	$req->execute(array('sess_id' => $sess_id));
	$_SESSION['login'] = "";
	$_SESSION['id'] = "";
	header("Location: index.php");
}
?>
