<?php
@require_once('./trainClass.php');
$conn = mysql_connect('localhost','root','');
	mysql_select_db('cloud_lab',$conn);
	print_r(getCourseTrain(1,1,1)) ;
	mysql_close($conn);
?>