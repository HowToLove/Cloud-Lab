<?php
header('Content-type: text/json');
session_start();
@require_once('../main/models/saveProgress.php');
@require_once('../main/models/getSnapOfPPT.php');
@require_once('../main/common/mysql_connect.php');
//当单独测试的时候本行需要使用，集成测试的时候注释掉
//$_SESSION['USER_ID']='12345';

//关闭自动输出error或者警告
ini_set("display_errors", "Off");

if(isset($_SESSION['USER_ID'])&&isset($_POST['action']))
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
			case null:
				$result = getSnapOfPPT($classId,$charpter,$lesson);
				//数据组装
				// $pptStatu = array('snap'=>$result);
				//返回请求结果
		    	echo json_encode($result);
			    /**例子
					{
				    "snap": {
				        "snap": [
				            "111a",
				            "222a",
				            "333a",
				            "444a",
				            "555a"
				        ],
				        "vedio": [
				            "111",
				            "112",
				            "113",
				            "114",
				            "115"
				        ]
				    }
				}
			    */
				break;
			case 'next':
				$next= getNext($classId,$charpter,$lesson);
				$result = getSnapOfPPT($classId,$next['charpter'],$next['lesson']);
				//返回请求结果
		    	echo json_encode($result);
				break;
			case 'prev':
				$prev= getPrev($classId,$charpter,$lesson);				
				$result = getSnapOfPPT($classId,$prev['charpter'],$prev['lesson']);
				//返回请求结果
		    	echo json_encode($result);
				break;
			case 'over'://下课，储存当前进度
				$status = saveProgress($classId,$charpter,$lesson);
				$ret = array('status'=>$status);
				echo json_encode($ret);
				break;
			case 'codeexample':
				$result = getCodeExample($classId,$charpter,$lesson);
				//返回请求结果
		    	echo json_encode($result);
				break;
			case 'video':
				$result = getVideoUrl($classId,$charpter,$lesson);
				//返回请求结果
				$videourl = array("url"=>$result);
		    	echo json_encode($videourl);
				break;
			case 'homework':
				$result = 
				getHomeworkOfLesson($classId,$charpter,$lesson);
				//返回请求结果
		    	echo json_encode($result);
				break;
			case 'recbooks':
				
				echo 'recbook';
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