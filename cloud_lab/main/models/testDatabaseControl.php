<?php
@require_once('./homework.php');
$conn = mysql_connect('localhost','root','');
	mysql_select_db('cloud_lab',$conn);
	print_r(checkallhomeworkremark(2,2)) ;
	
	mysql_close($conn);
?>