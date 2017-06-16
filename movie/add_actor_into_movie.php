<?php

session_start();
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php';
require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';

if($_GET["movie_id"] != null && $_GET["actor_id"] != null){
	
	//require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
	
	$db = new AccessBD();
	$db->connect();
	echo $db->insert_actor_into_movie($_GET["movie_id"], $_GET["actor_id"] , $_GET["role"]);
}

?>