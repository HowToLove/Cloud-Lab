<?php
//header('Content-type: text/json');
session_start();

@require_once('../main/models/getClassInfoById.php');
@require_once('../main/common/mysql_connect.php');
//当单独测试的时候本行需要使用，集成测试的时候注释掉
//$_SESSION['USER_ID']=124;
//$_SESSION['USER_TYPE']=2;
//var_dump($_SESSION);
	//创建数据库连接和选择数据库
	    $mysql = new Mysql;    
		//调用API获取数据
		$result = getClassInfoById($_SESSION['USER_ID']);
		//关闭数据库
		$mysql->close();
		//数据组装
		$status = array('classes'=>$result);
		
		//返回请求结果
   	 	echo json_encode($status);
   
?>