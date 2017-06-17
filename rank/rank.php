<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php";?>
</head>



<body>
<br><br>
<a href="/VSMS/rank/rank_consumption.php">會員下載排行</a>  
<a href="/VSMS/rank/genre_gross_most_month.php">類型最高月銷售</a>
<h3>電影下載排行</h3>
<form>

類別<?php include $_SERVER['DOCUMENT_ROOT'].'/VSMS/included/getGenreList.php';?>

從<input type="date" name="date_from" placeholder="2000-01-01">
到<input type="date" name="date_to" placeholder="2000-01-01">

<input type="submit" name="sub">
</form>

<?php 

if(isset($_GET["sub"])){
	$db = new AccessBD();
	$db->connect();
	
	if(empty($_GET["genre_type"]))
		$r = $db->query_movie_download(null, $_GET["date_from"], $_GET["date_to"]);
	
	else
		$r = $db->query_movie_download_with_genre(null, $_GET["date_from"], $_GET["date_to"] , $_GET["genre_type"]);
		
	echo '<table border="1"> <tr> <td>電影名稱</td> <td>上映日期</td> <td>下載量</td> </tr>';
	for($i = 0 ; $i < 10 && $i < $r->rowCount(); $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo '<tr><td>' .$obj->title .'</td>'
		.'<td>' .$obj->release_date .'</td>'
		.'<td>' .$obj->count .'</td>'
		.'</tr>';
	}
	echo '</table>';
}
?>

</body>
</html>
