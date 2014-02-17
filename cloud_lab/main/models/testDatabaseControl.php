<?php
@require_once('userhomepage.php');
	$conn = mysql_connect('localhost','root','');
	mysql_select_db('cloud_lab',$conn);
	print_r(json_encode(studentHomePageInfo(1)));
	print(json_encode(teacherHomePageInfo(5)));
	mysql_close($conn);
?>