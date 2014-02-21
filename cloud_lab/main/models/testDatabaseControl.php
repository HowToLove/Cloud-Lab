<?php
@require_once('./common.php');
$conn = mysql_connect('localhost','root','');
	mysql_select_db('cloud_lab',$conn);
	print_r(getPPTId(2,1,3)) ;
	mysql_close($conn);
?>