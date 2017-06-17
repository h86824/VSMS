<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
if($_SESSION["sess_auth"] != 1)
	header('Location:/VSMS/index.php');
?>

<html>
<head>
<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/header_inc.php'?>
<script type="text/javascript">
function ValidateNumber(e, pnumber)
{
    if (!/^\d+$/.test(pnumber))
    {
        var newValue =/^\d+/.exec(e.value);         
        if (newValue != null)         
        {             
            e.value = newValue;        
        }      
        else     
        {          
            e.value = "";    
        } 
    }
    return false;
}

function queryActor(){
	document.getElementById("actor_div").innerHTML="查詢中...";
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("actor_div").innerHTML=xmlhttp.responseText;
		}
	}
	var name = document.getElementById("text_actor").value;
	xmlhttp.open("GET","get_actor.php?actor_name="+name  ,true);
	xmlhttp.send();
}

function showAddActorList(){
	var text = '請輸入角色名字 <input type="text" id="text_role"><br>' +
		'請輸入演員名字 <input type="text" id="text_actor">'+
		'<button type="button" onclick="queryActor()">查詢</button>'+'<div id="actor_div"></div><br>';
	var list = document.getElementById("actor_list").innerHTML;
	document.getElementById("show_add_screen").innerHTML = text + list;
}

function selectActor(actorID){
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			location.reload();
		}
	}
	xmlhttp.open("GET","add_actor_into_movie.php?movie_id="+document.getElementById("movieID").value+"&actor_id="+actorID+"&role="+document.getElementById("text_role").value ,true);
	xmlhttp.send();
}

function update_movie(){
	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("change_check_div").innerHTML=
				'<button type="button" onclick="update_movie()">修改</button>' 
				+ xmlhttp.responseText;
		}
	}
	
	var text = "update_movie_page.php?movie_id="+document.getElementById("movieID").value
	+"&title="+document.getElementById("movie_title").value
	+"&release_date="+document.getElementById("release_date").value
	+"&company="+document.getElementById("company_name").value
	+"&charge_per_download="+document.getElementById("price").value;
	xmlhttp.open("GET", text
			 ,true);
	xmlhttp.send();
	document.getElementById("change_check_div").innerHTML=
		'<button type="button" onclick="update_movie()">修改基本資訊</button>'
		+"更新中...";
}

function queryDirector(){
	document.getElementById("director_div").innerHTML="查詢中...";
	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("director_div").innerHTML=xmlhttp.responseText;
		}
	}
	var name = document.getElementById("text_actor").value;
	xmlhttp.open("GET","get_director.php?director_name="+name  ,true);
	xmlhttp.send();
}

function goAddDirector(){
	var id = document.getElementById("movieID").value;
	location.replace("/VSMS/movie/add_director_into_movie.php?movie_id="+id);
}

function deletDirector(directID){
	var url ="/VSMS/movie/delete_director_from_movie.php";
	var id = document.getElementById("movieID").value;
	var parm="movie_id="+id+"&director_id="+directID;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			location.reload();
		}
	}
	xmlhttp.open("POST", url ,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(parm);
}

function deletActor(actorID){
	var url ="/VSMS/movie/delete_actor_from_movie.php";
	var id = document.getElementById("movieID").value;
	var parm="movie_id="+id+"&actor_id="+actorID;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			location.reload();
		}
	}
	xmlhttp.open("POST", url ,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(parm);
}

function insertGenre(){
	
	var url ="/VSMS/movie/insert_genre_into_movie.php";
	var id = document.getElementById("movieID").value;
	var parm="movie_id="+id+"&genre_name="+document.getElementById("genre_type").value;
	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			location.reload();
		}
	}
	xmlhttp.open("POST", url ,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(parm);
}

function deleteGenre(genreName){
	var url ="/VSMS/movie/delete_genre_from_movie.php";
	var id = document.getElementById("movieID").value;
	var parm="movie_id="+id+"&genre_name="+genreName;
	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			location.reload();
		}
	}
	
	xmlhttp.open("POST", url ,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(parm);
}

function deleteMovie(){
	
	
	if(confirm("確定要刪除嗎")){
		var url ="/VSMS/movie/delete_movie.php";
		var id = document.getElementById("movieID").value;
		var parm="movie_id="+id;
			
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				location.replace("/VSMS/movie/movie.php");
			}
		}
		
		xmlhttp.open("POST", url ,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(parm);
	}
}

</script>

</head>
<body>

<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php'?>
<br><br>
<a href="/VSMS/movie/movie.php">查詢電影</a>
<h3>編輯電影</h3>
<?php

if($_GET["movie_id"] != null){
	require $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/sql_connect_inc.php';
	$db = new AccessBD();
	$db->connect();
	$r = $db->query_movie($_GET["movie_id"] , null , null , null , null , null);
	echo '<button type="button" onclick="deleteMovie()">刪除電影</button><br><br>';
	echo "<form>";
	for($i = 0 ; $i < $r->rowCount() && $i<10 ; $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo '<input type=hidden value=' .$obj->movie_id.' id="movieID" name="movie_id">';
		echo '電影名稱 <input type=text name=movie_title id=movie_title value=' .$obj->title .'><br>';
		echo '上映日期 <input type="date" name="release_date" id=release_date placeholder="2000-01-01" value=' .$obj->release_date .'><br>';
		echo '發行公司 <input type="text" name="company_name" id="company_name" value="' .$obj->company.'"><br>';
		echo '下載價錢 <input type="text" style="ime-mode:disabled" id=price onkeyup="return ValidateNumber(this,value)" name="price" value=' .$obj->charge_per_download.'><br>';
		echo '<div id="change_check_div"><button type="button" onclick="update_movie()">修改基本資訊</button></div>';
		
		echo '<br>電影類型:';
		include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/getGenreList.php';
		echo '<button type="button" onclick="insertGenre()">新增類型</button><br>';
		$r = $db->query_genre_from_movie($_GET["movie_id"]);
		foreach( $r as $row){
			echo $row['genre_name'].'<button type="button" onclick="deleteGenre(this.value)" value='.$row['genre_name'].'>刪除</button><br>';
		}
		
		echo '<br>導演  :<br>';
		$r = $db->query_direct($_GET["movie_id"] , null);
		for($i = 0 ; $i < $r->rowCount() ; $i++){
			$obj = $r->fetch(PDO::FETCH_OBJ);
			echo $obj->name;
			echo '<button type="button" onclick="deletDirector(this.value)" value='.$obj->director_id.'>刪除導演</button><br>';
		}
		echo '<button type="button" onclick="goAddDirector()">加入導演</button><div id="edit_director"><div><br>';
		
		echo '演員列表  ';
		echo '<button type="button" onclick="showAddActorList()">加入演員</button>';
		echo '<div id="show_add_screen"></dir>';
		
	}
	
	echo'<div id="actor_list">';
	
	$r = $db->query_act($_GET["movie_id"] , null);
	for($i = 0 ; $i < $r->rowCount() ; $i++){
		$obj = $r->fetch(PDO::FETCH_OBJ);
		echo $obj->name ." 飾演 " .$obj->role;
		echo '<button type="button" onclick="deletActor(this.value)" value='.$obj->actor_id.'>刪除演員</button><br>';
	}
	echo '<br></div>';
	echo '</form>';
}
?>

</body>
</html>
