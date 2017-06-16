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
	echo '<a href="/VSMS/member/insert_member.php">新增會員</a>';
}
?>

<form method="get" name="form_query">
會員姓名<input type="text" name="name"> 
會員生日<input type="date" name="birthday" placeholder="2000-01-01"> 
會員電話<input type="text" name="phone"> 
<input type="submit" value="查詢" name="sub">
</form>

<?php 

if(isset($_GET["sub"])){
	require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
	
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_member(null , $_GET["name"], $_GET["birthday"], $_GET["phone"]);
	
	echo '<br><table border="1"><tr><td>會員姓名</td><td>會員生日</td><td>會員電話</td></tr>';
	for($i = 0 ; $i < $r->rowCount() && $i<10 ; $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo '<tr>';
		echo '<td>' .$obj->name .'</td>';
		echo '<td>' .$obj->birthday .'</td>';
		echo '<td>' .$obj->phone .'</td>';
		
		echo '<td><form action="/VSMS/member/download_record.php">
			<input type="submit" value="下載記錄">
			<input type="hidden" name="member_id" value="'.$obj->member_id.'"></form></td>';
		if($_SESSION["sess_auth"] == 1){
			echo'<td><form action="/VSMS/member/update_member.php">
			<input type="submit" value="編輯">
			<input type="hidden" name="member_id" value="'.$obj->member_id.'">
			</form></td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}
?>
</body>
</html>