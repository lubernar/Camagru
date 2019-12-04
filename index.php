<?php
if (session_status() != PHP_SESSION_ACTIVE)
	session_start();
include("comments.php");
$id = $_SESSION['id'];
include("navbar.php");
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
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
		<?php
		$req2 = $bdd->prepare('SELECT content, likes, creation_date FROM pictures WHERE user_id = :id');
		$req2->execute(array('id' => $id));
		$content = $req2->fetchAll(PDO::FETCH_ASSOC);

		?>
	<center><h1 style="font-size:2vw";><BR><BR>Community gallery<BR><BR><BR></h1></center>
<?php
$req2 = $bdd->prepare('SELECT id, content, likes, creation_date, user_id FROM pictures');
$req2->execute(array());
$content = $req2->fetchAll(PDO::FETCH_ASSOC);
$content = array_chunk($content, 3);
$req3 = $bdd->prepare('SELECT user_id, pictures_id, liked FROM pictures_liked WHERE user_id = :id');
$req3->execute(array('id' => $id));
$is_like = $req3->fetchAll(PDO::FETCH_ASSOC);
foreach($content as $row)
{
	echo "<div class=\"columns\">";
	foreach($row as $col)
	{
		$likedd = 0;
		$login_pic = $bdd->prepare('SELECT users.login FROM `pictures` INNER JOIN users ON users.id = user_id WHERE pictures.id = :pic_id');
		$login_pic->execute(array('pic_id' => $col["id"]));
		$login = $login_pic->fetch(PDO::FETCH_ASSOC);
		$nb_comments = $bdd->prepare('SELECT COUNT(id) AS nb_comments FROM `comments` WHERE pictures_id = :pic_id');
		$nb_comments->execute(array('pic_id' => $col['id']));
		$count_comments = $nb_comments->fetch(PDO::FETCH_ASSOC);
		echo '<div class="column is-4">
				<div class="card">
					<div class="card-image">
		 				<figure class="image is-fullwidth">
							<img src="'.$col['content'].'"/>
						</figure>
					</div>
					<div class="card-content"><strong>'.
					$login["login"]
					.'</strong> <I>'.$col['creation_date'].'</I>
						<nav class="level is-mobile">
							<div class="level-left">';
							echo '<form method="POST" name="formComment" action="comments.php?picture_id='.$col["id"].'">
							<article class="media">
							<div class="media-content">
							<div class="field">
							<p class="control">
							<textarea name="comment" class="textarea" placeholder="Add a comment..."></textarea>
							</p>
							</div>
							<button type="submit" name="commentButton" class="button is-info">Comment</buttton>
							<div class="level-right">
							<div class="level-item">
							</div>
							</div>
							</div>
							</article>
							</form>
							';
								echo '<a href="like.php?id='.$col["id"].'" class="level-item">';
								foreach ($is_like as $like)
								{
									if ($like['pictures_id'] == $col['id'])
										$likedd = 1;
									}
									if ($likedd == 1)
									echo '<span class="icon is-small has-text-danger"><i class="fas fa-heart"></i></span>'.
										$col["likes"];
									else
									echo '<span class="icon is-small has-text-grey"><i class="fas fa-heart"></i></span>'.
										$col["likes"];

								echo '</a>
							<a href="view_comments.php?id='.$col["id"].'">View comments('.$count_comments["nb_comments"].')</a>
							</div>
						</nav>
					</div>
				</div>
				</div>';
			}
			echo '</div>';

}


?>
	</body>
</html>
