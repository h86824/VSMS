<?php
	session_start();
	$_SESSION['sess_user'] = null;
	$_SESSION["sess_auth"] = null;
?>

<html>
<head>
<link type="text/css" rel="stylesheet" href="css/login.css">
</head>

<body>
<?php
require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/sql_connect_inc.php';

if(!empty($_POST["account"])){
	
	$db = new AccessBD();
	$check = $db->connect();
	if($check == true)
		echo "connect OK <br>";
	else{
		echo "connect fail <br>";
	}
	
	$account = $_POST["account"];
	$password = $_POST["password"];
	
	$login_check = $db->check_login($account,$password);
	if($login_check){
		$_SESSION["sess_user"] = $account;
		$_SESSION["sess_auth"] = $db->get_authorization($account);
		header("Location:operating.php");
	}
	else
		echo "login fail";
}
?>

<form action=login.php method="post">
<?php echo $_SESSION['sess_auth'] != null ? "login fail<br>" : "<br>"?>
Account: <input type="text" name="account"><br>
Password: <input type="password" name="password"><br>
<input type="submit">
</form>
</body>
</html>