<?php
session_start();
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
$req2 = $bdd->prepare('SELECT id, content, likes, creation_date FROM pictures');
$req2->execute(array());
$content = $req2->fetchAll(PDO::FETCH_ASSOC);
$content = array_chunk($content, 3);
$req3 = $bdd->prepare('SELECT user_id, pictures_id, liked FROM pictures_liked WHERE user_id = :id');
$req3->execute(array('id' => $id));
$liked = $req3->fetchAll(PDO::FETCH_ASSOC);
foreach($content as $row)
{
	echo "<div class=\"columns\">";
	foreach($row as $col)
	{
		echo '<div class="column is-4">
				<div class="card">
					<div class="card-image">
		 				<figure class="image is-fullwidth">
							<img src="'.$col['content'].'"/>
						</figure>
					</div>
					<div class="card-content">'.$col['creation_date'].'
						<nav class="level is-mobile">
							<div class="level-left">
								<a href="like.php?id='.$col["id"].'" class="level-item">';
								if ($liked[0]['user_id'] == $id && $liked[0]['pictures_id'] == $col['id'] && $liked[0]['liked'] == 1)
								{
									echo '<span class="icon is-small has-text-danger"><i class="fas fa-heart"></i></span>'.
									$col["likes"];
								}
								else
								{
									echo '<span class="icon is-small has-text-grey"><i class="fas fa-heart"></i></span>'.
									$col["likes"];

								}
								echo '</a>
							</div>
						</nav>
					</div>
				</div>
				</div>';
			}

}


?>
	</body>
</html>
