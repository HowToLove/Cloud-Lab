<?php
@require_once('./prepareClassModel.php');
	$conn = mysql_connect('localhost','root','');
	mysql_select_db('cloud_lab',$conn);
	var_dump(savePreparationPreClass(1,1,1,"savePreparationPreClass"));
	mysql_close($conn);
?>