<?php
session_start();
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
