<?php
session_start();
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
$req = $bdd->prepare('SELECT active FROM users WHERE id = ?');
$req->execute(array($id));
$active = $req->fetch(PDO::FETCH_ASSOC);
?>
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a href="index.php" class="navbar-item">
        <h1>Camgaru</h1>
      </a>
	<?php
		if ($_SESSION["login"] != "")
		{
			echo '<a href="webcam.php" class="navbar-item">
			My gallery
		  </a>';
		}
	?>
        </div>
      </div>
    </div>
	<?php
	if ($_SESSION['login'] == "")
	{
		echo '
		<div class="navbar-end">
			<div class="navbar-item">
				<div class="buttons">
					<a href="create_account.php" class="button is-primary">
						<strong>Sign up</strong>
					</a>
					<a href="login.php" class="button is-light">
						Log in
					</a>
				</div>
			</div>
		</div>';
	}
	else
	{
			if ($active['active'] != 1)
			{
				echo "<p style=\"color: red;\"> Your account is not verified yet, please check your mail </p>";
			}
			echo '
		<div class="navbar-end">
			<div class="navbar-item">
				<div class="buttons">
					<a href="logout.php" class="button is-primary">
						<strong>Logout</strong>
					</a>
					<a href="modify_account.php" class="button is-light">
						Modify account
					</a>
				</div>
			</div>
		</div>';
	}
	?>
  </div>
</nav>
