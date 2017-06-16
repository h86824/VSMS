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
if(isset($_GET["member_id"])){
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_member($_GET["member_id"] , null , null , null);
	
	$obj = $r->fetch(PDO::FETCH_OBJ);
	
	echo '<form>'
		.'<input type="hidden" name="member_id" value=' .$_GET["member_id"].'>'
		.'會員姓名 <input type="text" name="member_name" value="' .$obj->name .'"><br>'
		.'會員生日 <input type="date" name="birthday" placeholder="2000-01-01" value=' .$obj->birthday .'><br>'
		.'會員電話 <input type="text" name="phone" value=' .$obj->phone .'><br>'
		.'<input type="submit" value="修改" name="sub"><form>';
}

if(isset($_GET["sub"])){
	$db = new AccessBD();
	$db->connect();
	$r = $db->update_member($_GET["member_id"], $_GET["member_name"], $_GET["birthday"], $_GET["phone"]);
	
	header("location:/VSMS/member/update_member.php?member_id=" .$_GET["member_id"]);
}
?>
</body>
</html>