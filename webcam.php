<!DOCTYPE html>
<html lang="fr">
<head>
	<title>My gallery</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
  	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=yes">
<?php include("navbar.php");?>
</head>

<body>
	<div class="section">
		<div class="container">
			<center><h1 style="font-size:2vw";>My gallery</h1></center>
			<video id="sourcevid" height='400' width='400' autoplay="true" style='display:inline'></video>
			<div id="main" style='height:600px;width:600px;margin:auto;display:inline'>
			<button onclick='clone()' id="picture_button"class="button is-info">Take picture</button>
			<button id="save" class="button is-success">Save</button>
				<canvas value="" id="cvs" height='600px' width='600px'></canvas>
			</div>

<?php
$id = $_SESSION['id'];
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
$req = $bdd->prepare('SELECT content, likes, creation_date FROM pictures WHERE user_id = :id');
$req->execute(array('id' => $id));
$content = $req->fetchAll(PDO::FETCH_ASSOC);
$content = array_chunk($content, 3);
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
								<a class="level-item">
									<span class="icon is-small has-text-danger"><i class="fas fa-heart"></i></span>'.
									$col['likes'].'
								</a>
							</div>
						</nav>
					</div>
				</div>
			</div>';
	}
	echo '</div>';
}
?>
</div>
</div>
</body>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<script type="text/javascript">
	function init() {
		navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 800, height: 600 } }).then(function(mediaStream) {

			var video = document.getElementById('sourcevid');
			video.srcObject = mediaStream;

			video.onloadedmetadata = function(e) {
				video.play();
			};

		}).catch(function(err) { console.log(err.name + ": " + err.message); });

	}
	function clone()
	{
		var vivi = document.getElementById('sourcevid');
		var canvas1 = document.getElementById('cvs').getContext('2d');
		canvas1.drawImage(vivi, 0,0, 600, 480);
		$("#cvs").val('1');
	}

		$("#save").on('click', () => {
		var base64=document.getElementById('cvs').toDataURL("image/png");	//l'image au format base 64
		if ($("#cvs").val() == "1")
		{
			$.ajax(
			{
				url : '/upload_pictures.php',
				type : 'POST',
				data : {'content' : base64}
			}).then(() => {document.location.reload() ; });
			}
	});

	window.onload = init;
	</script>
</html>
