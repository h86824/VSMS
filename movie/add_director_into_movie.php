<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
if($_SESSION["sess_auth"] != 1)
	header('Location:/VSMS/index.php');
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>

<script type="text/javascript">
function queryDirector(){
	document.getElementById("director_div").innerHTML="查詢中...";
	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("director_div").innerHTML=xmlhttp.responseText;
		}
	}
	var name = document.getElementById("text_director").value;
	xmlhttp.open("GET","get_director.php?director_name="+name  ,true);
	xmlhttp.send();
}

function selectDirector(directorID){
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			location.replace("/VSMS/movie/update_movie.php?movie_id="+document.getElementById("movie_id").value);
		}
	}
	xmlhttp.open("GET","add_director_into_movie_page.php?movie_id="+document.getElementById("movie_id").value+"&director_id="+directorID  ,true);
	xmlhttp.send();
}

function goBack(){
	location.replace("/VSMS/movie/update_movie.php?movie_id="+document.getElementById("movie_id").value);
}

</script>

</head>

<body>
<br><br>
<button onclick="goBack()">返回</button><br>
導演名字<input type="text" name="director_name" id="text_director">
<button onclick="queryDirector()">查詢</button>
<div id="director_div"></div><br>

<?php 
if($_GET["movie_id"]){
	echo '<input type="hidden" id="movie_id" value='.$_GET["movie_id"].'>';
}
?>

</body>
</html>