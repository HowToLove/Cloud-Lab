<?php
header('Content-type: text/json');
session_start();

@require_once('../main/models/prepareClassModel.php');
@require_once('../main/common/mysql_connect.php');

ini_set("display_errors", "Off");
if(isset($_SESSION['USER_ID']) && isset($_POST['preparation']))//判断用户是否已经已经登录
{
	//获取请求参数数据
	$classId   		=	$_POST['classid'];
	$charpter  		=	$_POST['charpter'];
	$lesson    		=	$_POST['lesson'];
	$preparation	=	$_POST['preparation'];
	
	try {
		//创建数据库连接和选择数据库
	    $mysql = new Mysql;    
		//调用API获取数据
		savePreparationPreClass($classId,$charpter,$lesson,$preparation);
		//关闭数据库
		$mysql->close();
		//数据组装
		$charpter = array('status'=>"success");
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
}elseif(isset($_SESSION['USER_ID']) && 
		isset($_POST['remark'])){
	//获取请求参数数据
	$classId   		=	$_POST['classid'];
	$charpter  		=	$_POST['charpter'];
	$lesson    		=	$_POST['lesson'];
	$url			=	$_POST['url'];
	$remark			=	$_POST['remark'];
	try {
		//创建数据库连接和选择数据库
	    $mysql = new Mysql;    
		//调用API获取数据
		savePPTRemarkPreClass($classId,$charpter,$lesson,$url,$remark);
		//关闭数据库
		$mysql->close();
		//数据组装
		$charpter = array('status'=>"success");
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
	header("Location: http://localhost/cloud_lab/#tab-login");
}
ini_set("display_errors", "On");
?>