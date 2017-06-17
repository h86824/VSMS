<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
if($_SESSION["sess_auth"] != 1)
	header('Location:/VSMS/index.php');
	
if(isset($_POST["member_id"])){
	require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php";
	$db = new AccessBD();
	$db->connect();
	$db->delete_member($_POST["member_id"]);
}
?>