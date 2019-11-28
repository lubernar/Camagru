<?php
session_start();
echo "You need to be logged in to like a photo.";
$pictures_id = $_GET['id'];
$user_id = $_SESSION['id'];
if ($user_id !== "")
{
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}

	$req2 = $bdd->prepare('SELECT user_id, pictures_id, liked FROM pictures_liked WHERE user_id = :id');
	$req2->execute(array('id' => $user_id));
	$content = $req2->fetchAll(PDO::FETCH_ASSOC);
	if ($content[0]['user_id'] == $user_id && $content[0]['pictures_id'] == $pictures_id && $content[0]['liked'] == 1)
	{
		$req = $bdd->prepare('DELETE FROM pictures_liked WHERE pictures_id = :id');
		$req->execute(array('id' => $pictures_id));
		$req3 = $bdd->prepare('UPDATE pictures SET `likes`= likes - 1 WHERE `id`=:id_pic');
		$req3->execute(array('id_pic' => $pictures_id));
		header("Location: index.php");
	}
	else
	{
		$req = $bdd->prepare('INSERT INTO pictures_liked (user_id, pictures_id, liked) VALUES (:user_id, :pictures_id, :liked)');
		$req->execute(array('user_id' => $user_id, 'pictures_id' => $pictures_id, 'liked' => 1));
		$req3 = $bdd->prepare('UPDATE pictures SET `likes`= likes + 1 WHERE `id`=:id_pic');
		$req3->execute(array('id_pic' => $pictures_id));
		header("Location: index.php?like=1");
	}
}
?>
