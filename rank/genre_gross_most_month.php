
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
<a href="/VSMS/rank/rank.php">電影下載排行</a>
<a href="/VSMS/rank/rank_consumption.php">會員下載排行</a>
<h3>類型最高月銷售</h3>
<form>
查詢年份<input type="date" name="year" placeholder="2010">
<input type="submit" value="查詢 ">
</form>
<?php 
require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php";
if(isset($_GET["year"])){
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_genre_gross_most_month($_GET["year"]);
	
	echo '<table border="1"> <tr><td>類型</td> <td>月份</td> <td>銷售金額</td> </tr>';
	$temp;
	for($i = 0 ; $i < $r->rowCount() ; $i++){
		$obj= $r->fetch(PDO::FETCH_OBJ);
		echo '<tr>';
		echo '<td>'.$obj->genre_name.'</td>';
		echo '<td>'.$obj->month.'</td>';
		echo '<td>'.$obj->number.'</td>';
		echo '</tr>';
	}
	echo '</table>';
}


?>
</body>
</html>