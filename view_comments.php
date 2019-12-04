<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<title>Comments</title>
</head>
<body>
<?php include("navbar.php");?>
<div class="section">
<div class="container">
<div class="columns is-mobile is-centered">
<div class="column is-6">
<?php
if (session_status() != PHP_SESSION_ACTIVE)
	session_start();
$pic_id = $_GET['id'];
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
$req = $bdd->prepare('SELECT pictures.content FROM pictures WHERE id = :id');
$req->execute(array('id' => $pic_id));
$content = $req->fetch(PDO::FETCH_ASSOC);
$comments = $bdd->prepare('SELECT id, comment, writing_date FROM comments WHERE pictures_id = :pic_id');
$comments->execute(array('pic_id' => $pic_id));
$com = $comments->fetchAll(PDO::FETCH_ASSOC);
echo '<div class="card">
  <div class="card-image">
  <figure class="image">
	  <img src="'.$content['content'].'" alt="Placeholder image">
	</figure>
  </div>
  <div class="card-content">';
foreach ($com as $row)
{
	$user_id = $bdd->prepare('SELECT user_id FROM comments WHERE id = :comment_id');
	$user_id->execute(array('comment_id' => $row["id"]));
	$usr_id = $user_id->fetch(PDO::FETCH_ASSOC);
	$login = $bdd->prepare('SELECT users.login  FROM comments LEFT JOIN users ON comments.user_id=users.id WHERE user_id = :user_id');
	$login->execute(array('user_id' => $usr_id['user_id']));
	$log = $login->fetch(PDO::FETCH_ASSOC);
	echo '<article class="media">
	<div class="media-content">
	  <div class="content">
		<p>
		  <strong></strong> <small>@<strong>'.$log["login"].'</strong></small> <small><I>'.$row["writing_date"].'</I></small>
		  <br>'.
			$row["comment"]
		.'</p>
	  </div>
	</div>
  </article>';
}

?>
</div>
</div>
</div>
</div>
</div>
</section>


</body>
