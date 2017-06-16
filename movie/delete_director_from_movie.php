<?php

session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
?>

<?php 

if(isset($_POST["movie_id"]) && isset($_POST["director_id"])){
	require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/sql_connect_inc.php';
	$db = new AccessBD();
	$db->connect();
	$db->delete_director_from_movie($_POST["movie_id"], $_POST["director_id"]);
}
echo $_POST["movie_id"]." ".$_POST["director_id"];
?>
