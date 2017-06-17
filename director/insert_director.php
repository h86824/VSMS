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
<a href="/VSMS/director/director.php">查詢導演</a><br>
<h3>新增導演</h3>
<form action= <?php echo $_SERVER["PHP_SELF"]?> method="post">
導演姓名<input type="text" name="name"><br>
導演生日<input type="date" name="birthday" placeholder="2000-01-01"><br>
導演性別<select name="gender">
	<option value="male">male</option>
	<option value="female">female</option>
</select><br>
<input type="hidden" value=0 name="send">
<input type="submit" value="送出" name="sub">
</form>

<?php
require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
if(isset($_POST["sub"])){
	$db = new AccessBD();
	$db->connect();
	$r = $db->insert_director($_POST["name"], $_POST["birthday"] , $_POST["gender"]);
	echo "<br>".$r;
}
?>
</body>
</html>