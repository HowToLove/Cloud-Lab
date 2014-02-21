
<?php
header('Content-type: text/json');
@require_once("../main/models/askquestion.php");
@require_once('../main/common/mysql_connect.php');
@require_once('../main/models/common.php');

if(!isset($_SESSION))
{
	session_start();
}
	//header("Location: http://localhost/cloud_lab/index.html");

//当单独测试的时候本行需要使用，集成测试的时候注释掉
$_SESSION['USER_ID']=5;

//关闭自动输出error或者警告
ini_set("display_errors", "Off");
if(isset($_SESSION['USER_ID']))
{

	$action	   =	$_POST['action'];
	
	$mysql = new Mysql;
	switch (strtolower($action)) {
		case 'askquestion':
			$classid   =	$_POST['classid'];
			$charpter  =	$_POST['charpter'];
			$lesson    =	$_POST['lesson'];
			$askquestioncontent = $_POST['askquestion'];
			$site = $_POST['site'];
			
			$pptid = getPPTId($classid,$charpter,$lesson);
			$result = insertAskedQuestion($pptid,$classid,$_SESSION['USER_ID'],$askquestioncontent,$site);
			if($result >0 )
			{
				echo json_encode(array("status"=>"success"));
			}else{
				echo json_encode(array("status"=>"failure"));
			}
			break;
		case 'answerquestion':
		
			$askid = $_POST['askid'];
			$answer = $_POST['answer'];
			$result = insert_question_answer($askid,$answer);
			if($result)
			{
				echo json_encode(array('status'=>'success'));
			}else{
				echo json_encode(array('status'=>'failure'));
			}		
			break;
		default:
			echo json_encode(array("status"=>"default failure"));
			break;
	}
	$mysql->close();
}else{
	header("Location: http://localhost/cloud_lab/index.html");
}
//打开自动输出错误与警告
ini_set("display_errors", "On");
?>