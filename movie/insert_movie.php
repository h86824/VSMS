<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/login_check_inc.php';
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
</script>

</head>

<body>

<?php include $_SERVER["DOCUMENT_ROOT"].'/VSMS/included/menu_inc.php';?>
<br><br><a href="/VSMS/movie/movie.php">查詢電影</a>
<br><h3>新增電影</h3>
<form action= <?php echo $_SERVER["PHP_SELF"]?> method="post">
電影名稱<input type="text" name="movie_title"><br>
上映日期<input type="date" name="release_date" placeholder="2000-01-01"><br>
下載價錢<input type="text" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" name="price"><br>
<input type="hidden" value=0 name="send">
<input type="submit" value="送出" name="sub">
</form>


<?php
if(isset($_POST["sub"])){
	require $_SERVER["DOCUMENT_ROOT"] .'/VSMS/included/sql_connect_inc.php';
	$db = new AccessBD();
	$db->connect();
	$_POST["price"] = empty($_POST["price"])? 0 : $_POST["price"];
	$r = $db->insert_movie($_POST["movie_title"], $_POST["release_date"] , $_POST["price"]);
	echo "<br>".$r[1];
}
?>

</body>
</html>