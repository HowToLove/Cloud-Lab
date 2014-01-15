<?php
header('Content-type: text/json');
session_start();
@require_once('../main/models/prepareHomeworkModel.php');
@require_once('../main/common/mysql_connect.php');
//当单独测试的时候本行需要使用，集成测试的时候注释掉
// $_SESSION['USER_ID']='12345';

//关闭自动输出error或者警告
ini_set("display_errors", "Off");

if(isset($_SESSION['USER_ID']))
{
	//获取数据
	$classId   =	$_POST['classid'];
	$charpter  =	$_POST['charpter'];
	$lesson    =	$_POST['lesson'];
	$action	   =	$_POST['action'];
	try {
		$mysql = new Mysql;
		//invoke API
		switch ($action) {
			case 'homework':
				$question = $_POST['questionid'];
				
				TsaveAssignHomework($classId,$charpter,$lesson,$question);
				//数据组装
				$pptStatu = array('status'=>"success");
				//返回请求结果
		    	echo json_encode($pptStatu);
				break;
			case 'homeworklist':
				$result = 
				getAllQuestionOfLesson($classId,$charpter,$lesson);
				//返回请求结果
		    	echo json_encode($result);
				break;
			default:
				
				break;
		}
		$mysql->close();
		
	} catch (Exception $e) {
		echo json_encode($e->getTrace());
	}
}else{
	header("Location: http://localhost/cloud_lab/index.html");
}

//打开自动输出错误与警告
ini_set("display_errors", "On");
?>