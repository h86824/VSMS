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
<form action= <?php echo $_SERVER["PHP_SELF"]?> method="post">
演員姓名<input type="text" name="actor_name"><br>
演員生日<input type="date" name="actor_birthday" placeholder="2000-01-01"><br>
演員性別<select name="gender">
	<option value="male">male</option>
	<option value="female">female</option>
</select>
<input type="hidden" value=0 name="send">
<input type="submit" value="新增" name="sub">
</form>

<?php
if(isset($_POST["sub"]) ){
	require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
	$db = new AccessBD();
	$db->connect();
	
	$r = $db->insert_actor($_POST["actor_name"], $_POST["actor_birthday"] , $_POST["gender"]);
	
	echo $r;
}
?>


</body>
</html>