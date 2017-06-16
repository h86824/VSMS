<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php';
require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';

if($_GET["actor_name"]!=null){
	$db = new AccessBD();
	$db->connect();
	$result = $db->query_actor(null, $_GET["actor_name"], null);
	
	for($i = 0 ; $i < $result->rowCount() ; $i++){
		$obj = $result->fetch(PDO::FETCH_OBJ);
		echo " " .$obj->name ." " .$obj->birthday ." " .$obj->gender."<button type=button value = $obj->actor_id onclick=selectActor(this.value)>選擇</button>" ."<br>";
	}
}
else{
	echo "-請輸入演員名稱-";
}
?>