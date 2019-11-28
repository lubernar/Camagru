<?php
session_start();
$user_id = $_SESSION['id'];
$content = $_POST['content'];
if (!array_key_exists('content', $_POST))
	return ;
if (empty($content))
	return ;
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
$req = $bdd->prepare('INSERT INTO pictures (content, user_id) VALUES (:content, :user_id)');
$req->execute(array('content' => $content, 'user_id' => $user_id));
echo "OK\n";
?>
