<?php

session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
if($_SESSION["sess_auth"] != 1)
	header('Location:/VSMS/index.php');
?>

<?php 

if(isset($_POST["movie_id"]) && isset($_POST["actor_id"])){
	require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/sql_connect_inc.php';
	$db = new AccessBD();
	$db->connect();
	$db->delet_actor_from_movie($_POST["movie_id"], $_POST["actor_id"]);
}
echo $_POST["movie_id"]." ".$_POST["actor_id"];
?>
