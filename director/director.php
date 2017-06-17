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
<body>
<br><br>

<?php 
if($_SESSION["sess_auth"] == 1){
	echo '<a href="/VSMS/director/insert_director.php">新增導演</a>';
}
?>

<br><h3>查詢導演</h3>
<form>
導演姓名 <input type="text" name="name">
導演生日 <input type="date" name="birthday" placeholder="2000-01-01">
<input type="submit" name="sub">
</form>

<?php
require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';

if(isset($_GET["sub"]) && (!empty($_GET["name"]) || !empty($_GET["birthday"]))){
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_director(null, $_GET["name"], $_GET["birthday"], null);
	
	echo '<br><table border="1"><tr><td>導演姓名</td><td>導演生日</td><td>性別</td></tr>';
	for($i = 0 ; $i < $r->rowCount() && $i<10 ; $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo '<tr>';
		echo '<td>' .$obj->name .'</td>';
		echo '<td>' .$obj->birthday .'</td>';
		echo '<td>' .$obj->gender .'</td>';
		if($_SESSION["sess_auth"] == 1)
			echo '<td>'
			.'<form action="/VSMS/director/update_director.php">
			<input type="submit" value="編輯">
			<input type="hidden" name="director_id" value="'.$obj->director_id.'">
			</form>';
			echo '</tr>';
	}
	echo '</table>';
}
?>

</body>

</html>