<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>

</head>
<body>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';?>
<br><br>

<?php
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/sql_connect_inc.php';
if(isset($_GET["sub"])){
	$db = new AccessBD();
	$db->connect();
	$count = $db->update_director($_GET["director_id"] , $_GET["name"] , $_GET["birthday"] , $_GET["gender"]);
	
	if($r > 0)
		echo '資料修改完成';
	else
		echo '沒有資料被修改';
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_director($_GET["director_id"] , null , null , null);
	$obj = $r->fetch(PDO::FETCH_OBJ);
	
}

if(isset($_GET["director_id"])){
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_director($_GET["director_id"] , null , null , null);
	
	$obj = $r->fetch(PDO::FETCH_OBJ);
	
	echo '<form>'
		.'<input type="hidden" name="director_id" value=' .$_GET["director_id"].'>'
		.'導演姓名 <input type="text" name="name" value="' .$obj->name .'"><br>'
		.'導演生日 <input type="date" name="birthday" placeholder="2000-01-01" value=' .$obj->birthday .'><br>'
		.'導演性別 <select name="gender"><option'
		.($obj->gender=='male'?' selected':'')
		.'>male</option><option'
		.($obj->gender=='female'?' selected':'')
		.'>female</option></select><br>'
		.'<input type="checkbox" name="participate" value="yes">兼任演員<br>'
		.'<input type="submit" value="修改" name="sub"><form>';
}
?>