<?php
echo "<div class=welcome>歡迎使用 ".$_SESSION["sess_user"];
echo "<a href=\"/VSMS/logout.php\">登出</a></div><br><br>";

echo '<main_menu><a href="/VSMS/movie/movie.php">查詢電影</a>
<a href="/VSMS/actor/actor.php">查詢演員</a>
<a href="/VSMS/director/director.php">查詢導演</a>
<a href="/VSMS/member/member.php">查詢會員</a>
<a href="/VSMS/rank/rank.php">下載排行</a></main_menu>';
?>