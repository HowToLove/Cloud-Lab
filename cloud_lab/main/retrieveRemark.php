<?php
	require_once('./config/dbconfig.php');
	session_start();
	//echo json_encode($_POST);
	$con = mysql_connect(host,username,password);
	$userid = $_SESSION['USER_ID'];
	$classId = $_POST['classid'];
	$charpter = $_POST['charpter'];
	$lesson = $_POST['lesson'];	
	$pagenum = $_POST['pagenum'];
	if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
	mysql_select_db(dbname, $con);
	
	mysql_query("set names 'gbk'");	
	$remark=' ';
	$sql = "SELECT Remark.REMARK AS pptremark FROM t_ppt_remark Remark,t_ppt_info Info,t_class_info Class 
		WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
		AND Remark.PPT_ID = Info.PPT_ID AND Info.COURSE_CHARPTER = "."$charpter".
		" AND Info.LESSON_SEQ = "."$lesson"." AND Remark.PPT_PAGE_NUM = "."$pagenum AND Remark.user_id = $userid";
	$result = mysql_query($sql);	
	if(mysql_num_rows($result)>=1){
		$row = mysql_fetch_array($result);
		$remark = iconv('gbk//IGNORE','UTF-8',$row['pptremark']); 
	}
	
	echo json_encode(array('remark'=>$remark));
	mysql_close($con);
?>