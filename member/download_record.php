<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>
</head>
<br><br>

<body>

<?php 
require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php";
if(isset($_GET["member_id"])){
	$db = new AccessBD();
	$db->connect();
	
	$r = $db->query_favorite_actress($_GET["member_id"]);
	echo '最喜歡的女演員 :<br>';
	if($r->rowCount() == 0)
		echo '尚無資料<br>';
	for($i = 0 ; $i < $r->rowCount() ; $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo $obj->name ." " .$obj->birthday ."<br>";
	}
	
	$r = $db->query_favorite_actor($_GET["member_id"]);
	echo '<br>最喜歡的男演員 :<br>';
	if($r->rowCount() == 0)
		echo '尚無資料<br>';
	for($i = 0 ; $i < $r->rowCount() ; $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo $obj->name ." " .$obj->birthday ."<br>";
	}
	
	$r = $db->query_user_download_record($_GET["member_id"]);
	
	echo '<br><table border="1"> <tr> <td>下載日期</td> <td>電影名稱</td> <td>上映日期</td> </tr>';
	for($i = 0 ; $i < 10 && $i < $r->rowCount(); $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo '<tr><td>' .$obj->date .'</td>'
		.'<td>' .$obj->title .'</td>'
		.'<td>' .$obj->release_date .'</td>'
		.'</tr>';
	}
	echo '</table>';
}
?>

</body>
</html>