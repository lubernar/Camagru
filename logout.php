<?php
session_start();
$_SESSION['login'] = "";
$_SESSION['id'] = "";
echo $_SESSION['login'] = "";
header("Location: http://localhost:8080");
?>