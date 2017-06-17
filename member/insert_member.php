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
<a href="/VSMS/member/member.php">查詢會員</a><br><br>
<form action= <?php echo $_SERVER["PHP_SELF"]?> method="post">
會員姓名 <input type="text" name="name"><br>
會員生日 <input type="date" name="birthday" placeholder="2000-01-01"><br>
會員電話 <input type="text" name="phone" ><br>
<input type="hidden" value=0 name="send">
<input type="submit" value="送出" name="sub">
</form>

<?php
require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
if(isset($_POST["sub"])){
	$db = new AccessBD();
	$db->connect();
	$r = $db->insert_member($_POST["name"], $_POST["birthday"] , $_POST["phone"]);
	echo "<br>".$r;
}
?>
</body>
</html>