<?php 
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>
<?php require $_SERVER["DOCUMENT_ROOT"]."/VSMS/included/sql_connect_inc.php"?>
</head>


<body>
<br><br>

<?php 
if($_SESSION["sess_auth"] == 1){
	echo '<a href="/VSMS/movie/insert_movie.php">新增電影</a>';
}
?>

<form method="get">
電影名稱 <input type="text" name="movie_name"> 
發售日期 從 <input type="date" name="release_from" placeholder="2000-01-01">
到 <input type="date" name="release_to" placeholder="2000-01-01">

演員 <input type="text" name="actor_name">

類型
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/getGenreList.php'?>

排序方法
<select name="sort_type">
<option value="release_date_descending">上映日期(新->舊)</option>
<option value="release_date_ascending">上映日期(舊->新)</option>
</select>

<input type="submit" value="查詢" name="sub">
</form>

<?php
if(isset($_GET["sub"])){
	echo "<br>以下是查詢結果";
	
	$db = new AccessBD();
	$db->connect();
	echo $_GET["movie_name"];
	if(empty($_GET["actor_name"]))
		$r = $db->query_movie(null,$_GET["movie_name"], $_GET["release_from"], $_GET["release_to"], $_GET["genre_type"], $_GET["sort_type"]);
	else
		$r = $db->query_movie_with_actor(null,$_GET["movie_name"], $_GET["release_from"], $_GET["release_to"], $_GET["actor_name"] ,$_GET["film_type"], $_GET["sort_type"]);
		
	echo '<br><table border="1"><tr><td>id</td><td>電影名稱</td><td>上映日期</td><td>價格</td><td>下載次數</td></tr>';
	for($i = 0 ; $i < $r->rowCount() && $i<10 ; $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo '<tr>';
		echo '<td>' .$obj->movie_id .'</td>';
		echo '<td>' .$obj->title .'</td>';
		echo '<td>' .$obj->release_date .'</td>';
		echo '<td>' .$obj->charge_per_download .'</td>';
		echo '<td>'.'</td>';
		
		if($_SESSION["sess_auth"] == 1)
			echo '<td>' 
			.'<form action="/VSMS/movie/update_movie.php">
			<input type="submit" value="編輯">
			<input type="hidden" name="movie_id" value="'.$obj->movie_id.'">
			</form>';
		
		echo '</tr>';
	}
	echo '</table>';
}
?>

</body>
</html>

