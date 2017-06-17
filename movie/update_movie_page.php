<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
if($_SESSION["sess_auth"] != 1)
	header('Location:/VSMS/index.php');

if(isset($_GET["movie_id"])){
	require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
	
	$db = new AccessBD();
	$db->connect();
	$r = $db->update_movie($_GET["movie_id"], $_GET["title"], $_GET["release_date"], $_GET["company"] ,$_GET["charge_per_download"]);
	
	echo $r;
}

?>

