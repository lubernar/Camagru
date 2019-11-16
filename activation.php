<?php
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
$token = $_GET['token'];
$login = $_GET['log'];
$stmt = $bdd->prepare("SELECT token, active FROM users WHERE login like :login ");
if($stmt->execute(array(':login' => $login)) && $row = $stmt->fetch())
{
	$tokenbdd = $row['token'];
	$active = $row['active'];
}
if ($active == '1')
{
	echo "Accout already activated !";
}
else
{
	// echo $token . "\n";
	// echo $tokenbdd;
	if ($token == $tokenbdd)
	{
		echo "Your account has been successfully activated !";
		$stmt = $bdd->prepare("UPDATE users SET active = 1 WHERE login like :login ");
		$stmt->bindParam(':login', $login);
		$stmt->execute();
	}
	else
	{
		echo "Error ! Your account can not be activated...";
	}
}

?>
