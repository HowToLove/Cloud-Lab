<?php
header('Content-type: text/json');
@require_once("../main/models/homework.php");
@require_once('../main/common/mysql_connect.php');

if(!isset($_SESSION))
{
	session_start();
}
	//header("Location: http://localhost/cloud_lab/index.html");

//当单独测试的时候本行需要使用，集成测试的时候注释掉
$_SESSION['USER_ID']=5;
$_SESSION['USER_TYPE']='teacher';

//关闭自动输出error或者警告
ini_set("display_errors", "Off");
if(isset($_SESSION['USER_ID']))
{
	$classid   =	$_POST['classid'];
	$charpter  =	$_POST['charpter'];
	$lesson    =	$_POST['lesson'];
	$action	   =	$_POST['action'];
	
	switch ($_SESSION['USER_TYPE']) {
		case '1':
		case 1:
		case 'student':
			switch ($action) {
				case 'handinhomework':
					$questionid = $_POST['questionid'];
					$result = stu_handin_a_question_of_homework($classid,$charpter,$lesson,$questionid,$_SESSION['USER_ID'],$answer);
					if($result >0 )
					{
						echo json_encode(array("status"=>"success"));
					}else{
						echo json_encode(array("status"=>"failure"));
					}
					break;
				case 'checkallhomework':
					$result = checkallhomeworkremark($classid,$_SESSION['USER_ID']);
					echo json_encode(array("homework"=>$result));
					break;
				default:
					.
					break;
			}
			
		case '2':
		case  2:
		case 'teacher':
			switch ($action) {
				case 'commitremark':
					$studentid = $_POST['studentid'];
					$questionid = $_POST['questionid'];
					$remark = $_POST['remark'];
					$result = teacher_submit_check_info($_SESSION['USER_ID'],$studentid,$questionid,$remark);
					if($result)
						{
							echo json_encode(array('status'=>'success'));
						}else{
							echo json_encode(array('status'=>'failure'));
						}		
					break;
				case 'updateremark':
					$studentid = $_POST['studentid'];
					$questionid = $_POST['questionid'];
					$remark = $_POST['remark'];
					$result = teacher_update_check_info($_SESSION['USER_ID'],$studentid,$questionid,$remark);
					if($result)
						{
							echo json_encode(array('status'=>'success'));
						}else{
							echo json_encode(array('status'=>'failure'));
						}		
					break;
				default:
					# code...
					break;
			}
		default:
			$result  = getUserBaseInfoById($_SESSION['USER_ID']);
			echo json_encode($result);
			break;
	}
}else{
	header("Location: http://localhost/cloud_lab/index.html");
}
//打开自动输出错误与警告
ini_set("display_errors", "On");
?>