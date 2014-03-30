<?php
header('Content-type: text/json');
session_start();

@require_once('../main/models/coursedetailModel.php');
@require_once('../main/common/mysql_connect.php');
//当单独测试的时候本行需要使用，集成测试的时候注释掉
//$_SESSION['USER_ID']='5';
//$_SESSION['USER_TYPE']=2;

ini_set("display_errors", "Off");
if(isset($_SESSION['USER_ID']) )//判断用户是否已经已经登录
{
	//获取请求参数数据
	$classId = $_POST['classid'];
	try {
		//创建数据库连接和选择数据库
	    $mysql = new Mysql;    
		//调用API获取数据
		$result = getCourseDetail($classId);
		//关闭数据库
		$mysql->close();
		//数据组装
		$charpter = array('charpter'=>$result);
		//返回请求结果
   	 	echo json_encode($charpter);
   	 	/**例子
		{
	    "charpter": 
	       [
		        3,
		        4,
		        2
	       ]
		}	
   	 	*/
	} catch (Exception $e) {
		echo json_encode($e->getTrace());
	}
}else{
	header("Location: http://localhost/GecLab/#tab-login");
}
ini_set("display_errors", "On");
?>