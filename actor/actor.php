<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>
</head>

<body>
<br><br>
<?php 
if($_SESSION["sess_auth"] == 1){
	echo '<a href="/VSMS/actor/insert_actor.php">新增演員</a>';
}
?>
<br><h3>查詢演員</h3>
<form method="get">
演員名字<input type="text" name="actor_name">
<input type="submit" value="查詢"><br>
</form>

<?php 
if(isset($_GET["actor_name"]) && $_GET["actor_name"] != null){
	require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
	
	$db = new AccessBD();
	$db->connect();
	$result = $db->query_actor(null, $_GET["actor_name"], null);
	
	for($i = 0 ; $i < $result->rowCount() ; $i++){
		$obj = $result->fetch(PDO::FETCH_OBJ);
		echo " " .$obj->name ." " .$obj->birthday ." " .$obj->gender;
		if($_SESSION["sess_auth"] == 1)
			echo"<button type=button value = $obj->actor_id onclick=updateActor(this.value)>更新資料</button>" ."<br>";
	}
}
?>

</body>
</html>
