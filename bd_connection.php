<?php
function bd_connection($bdd)
{

	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', 'rootroot');
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
}
?>
