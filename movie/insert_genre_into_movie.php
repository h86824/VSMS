<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';

if(isset($_POST["movie_id"]) && isset($_POST["genre_name"])){
	require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php";
	$db = new AccessBD();
	$db->connect();
	$db->insert_genre_into_movie($_POST["movie_id"], $_POST["genre_name"]);
}
?>