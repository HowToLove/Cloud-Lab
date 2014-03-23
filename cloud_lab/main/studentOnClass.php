<?php
	require_once('./config/dbconfig.php');
	session_start();
	//echo json_encode($_POST);
	$con = mysql_connect(host,username,password);
	/*
	data : {
				'classid' : classid,
				'charpter' : charpter,
				'lesson' : lesson,
				'pleft' : pleft,
				'ptop' : ptop,
				'content' : content,
				'pagenum':pageNum,
				'isInsert':insert_id,
				'pstartx' : pstartx,
				'pstarty' : pstarty,
				'pendx' : pendx,
				'pendy' = pendy
	}
	*/
	//var_dump($_SESSION);
	$userid = $_SESSION['USER_ID'];
	$classid = $_POST['classid'];
	$charpter = $_POST['charpter'];
	$lesson = $_POST['lesson'];
	$pleft = $_POST['pleft'];
	$ptop = $_POST['ptop'];
	$content = $_POST['content'];
	$pagenum = $_POST['pagenum'];
	$itemId = $_POST['isInsert'];
	$pstartx = $_POST['pstartx'];
	$pstarty = $_POST['pstarty'];
	$pendx = $_POST['pendx'];
	$pendy = $_POST['pendy'];
	if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(dbname, $con);
		$content = iconv('UTF-8','gb2312//IGNORE',$content);
		mysql_query("set names 'gbk'");
	if($itemId == -1){
				
		$sql = "INSERT INTO T_STUDENT_REMARK (user_id,class_id,charpter_id,lesson_id,page_num,pleft,ptop,content,pstartx,pstarty,pendx,pendy) 
										VALUES ($userid,$classid,$charpter,$lesson,$pagenum,$pleft,$ptop,'$content',$pstartx,$pstarty,$pendx,$pendy)";		
		mysql_query($sql);
		echo json_encode(array('insert_id'=>mysql_insert_id()));
	}else{
		$sql = "UPDATE T_STUDENT_REMARK SET content = '$content' WHERE item_id = $itemId";
		mysql_query($sql);
		echo json_encode(array('insert_id'=>-1));
	}
	mysql_close($con);
?>