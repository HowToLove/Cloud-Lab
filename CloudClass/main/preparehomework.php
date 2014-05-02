<?php
header('Content-type: text/json');
session_start();
@require_once('../main/models/prepareHomeworkModel.php');
@require_once('../main/common/mysql_connect.php');
//���������Ե�ʱ������Ҫʹ�ã����ɲ��Ե�ʱ��ע�͵�
//$_SESSION['USER_ID']='5';

//�ر��Զ����error���߾���
ini_set("display_errors", "Off");

if(isset($_SESSION['USER_ID']))
{
	//��ȡ����
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
				//������װ
				$pptStatu = array('status'=>
"success");
				//����������
		    	echo json_encode($pptStatu);
				break;
			case 'homeworklist':
				$result = 
				getAllQuestionOfLesson($classId,$charpter,$lesson);
				//����������
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
	header("Location: http://localhost/GecLab/index.html");
}

//���Զ���������뾯��
ini_set("display_errors", "On");
?>