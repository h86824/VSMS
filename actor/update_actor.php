<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
if($_SESSION["sess_auth"] != 1)
	header('Location:/VSMS/index.php');
	?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>

<script type="text/javascript">
function deleteActor(){
	if(confirm("確定要刪除嗎")){
		var url ="/VSMS/actor/delete_actor.php";
		var id = document.getElementById("actor_id").value;
		var parm="actor_id="+id;
		
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				location.replace("/VSMS/actor/actor.php");
			}
		}
		
		xmlhttp.open("POST", url ,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parm);
	}
}
</script>

</head>
<body>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';?>


<br><br>
<button type="button" onclick="deleteActor()">刪除演員</button><br><br>
<?php
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/sql_connect_inc.php';
if(isset($_GET["sub"])){
	$db = new AccessBD();
	$db->connect();
	$count = $db->update_actor($_GET["actor_id"] , $_GET["name"] , $_GET["birthday"] , $_GET["gender"]);
	
	if($count> 0)
		echo '資料修改完成';
	else
		echo '沒有資料被修改';
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_actor($_GET["actor_id"] , null , null , null);
	$obj = $r->fetch(PDO::FETCH_OBJ);
	
}

if(isset($_GET["actor_id"])){
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_actor($_GET["actor_id"] , null , null , null);
	
	$obj = $r->fetch(PDO::FETCH_OBJ);
	echo '<form>'
		.'<input type="hidden" name="actor_id" id="actor_id" value=' .$_GET["actor_id"].'>'
		.'演員姓名 <input type="text" name="name" value="' .$obj->name .'"><br>'
		.'演員生日 <input type="date" name="birthday" placeholder="2000-01-01" value=' .$obj->birthday .'><br>'
		.'演員性別 <select name="gender"><option'
		.($obj->gender=='male'?' selected':'')
		.'>male</option><option'
		.($obj->gender=='female'?' selected':'')
		.'>female</option></select><br>'
		.'<input type="submit" value="修改" name="sub"><form>';
}
?>