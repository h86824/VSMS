
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
<a href="/VSMS/rank/genre_gross_most_month.php">類型最高月銷售</a>
<h3>會員下載排行</h3>
<form>

<?php 
require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php";

$db = new AccessBD();
$db->connect();
$r = $db->query_consumption_ranking(10);
	
echo '<table border="1"> <tr><td>排名</td> <td>會員姓名</td> <td>會員生日</td> <td>消費金額</td> </tr>';
for($i = 0 ; $i < 10 && $i < $r->rowCount(); $i++){
	$obj = $r->fetch(PDO::FETCH_OBJ);
	echo '<tr><td>' .($i+1) .'</td>'
	.'<td>' .$obj->name .'</td>'
	.'<td>' .$obj->birthday .'</td>'
	.'<td>' .$obj->total .'</td>'
	.'</tr>';
}
echo '</table>';

?>
</form>
</body>
</html>