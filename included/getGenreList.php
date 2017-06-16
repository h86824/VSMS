 
<?php
$db = new AccessBD();
$db->connect();
$r = $db->get_genres();
echo '<select name="genre_type" id="genre_type">
	<option value="">--</option>';
foreach($r as $row){
	echo '<option value='.$row['genre_name'].'>'.$row["genre_name"].'</option>';
}
echo '</select>';
?>

