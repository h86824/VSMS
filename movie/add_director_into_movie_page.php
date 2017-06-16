<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>
</head>
<body>
<?php 

if(isset($_GET["movie_id"]) && isset($_GET["director_id"])){
	require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php";
	
	$db = new AccessBD();
	$db->connect();
	$db->insert_director_into_movie($_GET["movie_id"], $_GET["director_id"]);
}
?>

</body>
</html>