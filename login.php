<?php
	session_start();
	$_SESSION['sess_user'] = null;
	$_SESSION["sess_auth"] = null;
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>
<link type="text/css" rel="stylesheet" href="css/vsms.css">
</head>

<body>
<h1>登入系統</h1>
<?php
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/sql_connect_inc.php';

if(!empty($_POST["account"])){
	
	$db = new AccessBD();
	$check = $db->connect();
	
	$account = $_POST["account"];
	$password = $_POST["password"];
	
	$login_check = $db->check_login($account,$password);
	if($login_check){
		$_SESSION["sess_user"] = $account;
		$_SESSION["sess_auth"] = $db->get_authorization($account);
		header("Location:index.php");
	}
	else
		echo "<error>帳號或密碼錯誤</error>";
}
else if(isset($_POST["account"])){
	echo "<error>請輸入帳號</error>";
}
?>

<form action=login.php method="post">
<?php echo $_SESSION['sess_auth'] != null ? "login fail<br>" : "<br>"?>
帳號: <input type="text" name="account"><br>
密碼: <input type="password" name="password"><br>
<input type="submit" value="登入">
</form>
</body>
</html>