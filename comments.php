<?php
if (session_status() != PHP_SESSION_ACTIVE)
	session_start();
	if (isset($_POST['commentButton']))
	{
		$pic_id = $_GET['picture_id'];
		$comment = $_POST['comment'];
		$comment = $_POST['comment'];
		try
		{
			$bdd5 = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
			$bdd5->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		$req = $bdd5->prepare('INSERT INTO comments (pictures_id, comment, user_id) VALUES (:pictures_id, :comment, :user_id)');
		$req->execute(array('pictures_id' => $pic_id, 'comment' => $comment, 'user_id' => $_SESSION['id']));
		header("Location: index.php");
	}
?>
