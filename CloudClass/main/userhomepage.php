<?php
header('Content-type: text/json');
@require_once("../main/models/userhomepage.php");
@require_once('../main/common/mysql_connect.php');

if(!isset($_SESSION))
{
	session_start();
}
	//header("Location: http://localhost/cloud_lab/index.html");

//当单独测试的时候本行需要使用，集成测试的时候注释掉
//$_SESSION['USER_ID']=5;
//$_SESSION['USER_TYPE']='teacher';

//关闭自动输出error或者警告
ini_set("display_errors", "Off");
if(isset($_SESSION['USER_ID']))
{
	//获取数据
		try {
			$mysql = new Mysql();
			//invoke API
			switch ($_SESSION['USER_TYPE']) {
				case '1':
				case 1:
				case 'student':
					$result =  studentHomePageInfo($_SESSION['USER_ID']);
					echo json_encode($result);
					break;
				case '2':
				case  2:
				case 'teacher':
					$result =  teacherHomePageInfo($_SESSION['USER_ID']);
					echo json_encode($result);
					break;
				default:
					$result  = getUserBaseInfoById($_SESSION['USER_ID']);
					echo json_encode($result);
					break;
			}
			$mysql->close();
		} catch (Exception $e) {
			echo json_encode($e->getTrace());
		}
}else{
	header("Location: http://localhost/GecLab/index.html");
}
//打开自动输出错误与警告
ini_set("display_errors", "On");
?>