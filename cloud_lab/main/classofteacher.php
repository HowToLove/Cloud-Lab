<?php
header('Content-type: text/json');
session_start();

@require_once('../main/models/getClassInfoById.php');
@require_once('../main/common/mysql_connect.php');
//当单独测试的时候本行需要使用，集成测试的时候注释掉
// $_SESSION['USER_ID']='5';
// $_SESSION['USER_TYPE']=2;
// var_dump($_SESSION);

ini_set("display_errors", "Off");

if(isset($_SESSION['USER_ID']))//判断用户是否已经已经登录
{
	//获取请求参数数据
	
	try {
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
   	 	
   	 	/**例子
   	 	*{
		    "classes": [
		        {
		            "classid": "1",
		            "classname": "HTML class 1",
		            "coursename": "HTML5",
		            "imgurl": "/image/course-html5.png",
		            "progress": {
		                "charpter": "3",
		                "lesson": 2,
		                "percent": 0.88888888888889
		            },
		            "description": "A very complicated course!",
		            "studentsnum": "4"
		        },
		        {
		            "classid": "2",
		            "classname": "Java Lanxiang",
		            "coursename": "JAVA",
		            "imgurl": "/image/course-java.png",
		            "progress": {
		                "charpter": "1",
		                "lesson": 1,
		                "percent": 0
		            },
		            "description": "So easy!",
		            "studentsnum": "0"
		        }
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