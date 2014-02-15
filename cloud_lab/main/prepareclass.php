<?php
header('Content-type: text/json');
@require_once('../main/models/prepareClassModel.php');
@require_once('../main/common/mysql_connect.php');
@require_once('../main/models/coursedetailModel.php');
@require_once('../main/models/getPrepareClassInfoById.php');
if(!isset($_SESSION))
{
	session_start();
}

//当单独测试的时候本行需要使用，集成测试的时候注释掉
$_SESSION['USER_ID']='5';

//关闭自动输出error或者警告
ini_set("display_errors", "Off");
if(isset($_SESSION['USER_ID']))
{
		if(isset($_POST['action']))
		{		
			//获取数据
			$classId   =	$_POST['classid'];
			$charpter  =	$_POST['charpter'];
			$lesson    =	$_POST['lesson'];
			$action	   =	$_POST['action'];
			try {
				//var_dump($_POST);
				$mysql = new Mysql;
				//invoke API
				switch ($action) {
					case null://拉取该教师所教课程的列表
						$result = getPrepareClassInfoById($_SESSION['USER_ID']);
						echo json_encode(array('classes'=>$result));
						break;
					case 'courseDetail'://获取课程章节详细信息
						$result = getCourseDetail($classId);
						$charpter = array('charpter'=>$result);
						//返回请求结果
		   	 			echo json_encode($charpter);
						break;
					case 'getPPTandRemark':
						$resultOfPPT = getSnapAndRemarkOfPPT($classId,$charpter,$lesson);
						$resultOfPreparation = getPreparationByClassIdCharpterLession($classId,$charpter,$lesson);
						$result=array_merge($resultOfPPT,$resultOfPreparation);
						echo json_encode($result);
						break;
					case 'commitRemark'://提交ppt备注
						$result = savePPTRemarkPreClass($classId,$charpter,$lesson,$_POST['pagenum'],$_POST['remark']);
						//echo $_POST['remark'];
						if($result)
						{
							echo json_encode(array('status'=>'success'));
						}else{
							echo json_encode(array('status'=>'failure'));
						}		
						break;	
					case 'homeworklist':
						$result = getAllQuestionOfLesson($classId,$charpter,$lesson);
						echo json_encode(array('questions'=>$result));
						break;
					case 'homework'://储存教师布置的作业			
						$result = saveHomeworkList($classId,$charpter,$lesson,$_POST['questionids'],$_POST['deadline']);
						if($result)
						{
							echo json_encode(array('status'=>'success'));
						}else{
							echo json_encode(array('status'=>'failure'));
						}	
					default:
						
						break;
				}
				$mysql->close();
				
			} catch (Exception $e) {
				echo json_encode($e->getTrace());
			}
		}elseif (isset($_POST['preparation'])) {
			//获取请求参数数据
			$classId   		=	$_POST['classid'];
			$charpter  		=	$_POST['charpter'];
			$lesson    		=	$_POST['lesson'];
			$preparation	=	$_POST['preparation'];
			
			try {
				//创建数据库连接和选择数据库
			    $mysql = new Mysql;    
				//调用API获取数据
				$status = savePreparationPreClass($classId,$charpter,$lesson,$preparation);
				//关闭数据库
				$mysql->close();
				//数据组装
				if($status)
				{
					$charpter = array('status'=>"success");
				}else{
					$charpter = array('status'=>"failure");
				}
				
				//返回请求结果
		   	 	echo json_encode($charpter);
			} catch (Exception $e) {
				echo json_encode($e->getTrace());
			}
		}else{
			//var_dump($_POST);
			$mysql = new Mysql;
			$result = getPrepareClassInfoById($_SESSION['USER_ID']);
			echo json_encode(array('classes'=>$result));
			$mysql->close();
		}
}else{
		header("Location: http://localhost/cloud_lab/index.html");
	}

//打开自动输出错误与警告
ini_set("display_errors", "On");
?>