<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php';
require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';

if($_GET["director_name"]!=null){
	$db = new AccessBD();
	$db->connect();
	$result = $db->query_director(null, $_GET["director_name"], null ,null);
	
	for($i = 0 ; $i < $result->rowCount() ; $i++){
		$obj = $result->fetch(PDO::FETCH_OBJ);
		echo " " .$obj->name ." " .$obj->birthday ." " .$obj->gender."<button type=button value = $obj->director_id onclick=selectDirector(this.value)>加入</button>" ."<br>";
	}
}
else{
	echo "-請輸入演員名稱-";
}
?>