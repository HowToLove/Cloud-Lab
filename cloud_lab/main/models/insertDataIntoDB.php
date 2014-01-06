<?php
  /**
	*本文件用来封装基本的插入数据表记录的函数，用来基本的添加记录
	*@createtime 2013-12-28
	*@author  
	*/
require_once('../common/mysql_connect.php');
function insertClassInfo($arr){
	$table = 't_class_info';
	$columns = array('TEACHER_ID','COURSE_ID','CLASS_NAME','CLASS_BEGIN','CLASS_END');
	
	if(count($arr) == count($columns))
	{
		$insertData = array_combine($columns,$arr);//这是数组的PHP内置函数 ，函数括号中的前一个数组的值为新数组的索引，后一个参数的值为新数组的值
		//var_dump($insertData);
		try {
			$mysql = new Mysql;
			$mysql->insert($table,$insertData);
		
			$mysql->close();
		} catch (Exception $e) {
			//error_log($e->getTrace());
			}
    }
}
/**
 *@param $arr 要向pptinfo中插入的 数据
 *
 */
function insertPPTInfo($arr)
{
	$tablename  = 't_ppt_info';
	$columns = array('COURSE_ID','COURSE_CHARPTER','LESSON_SEQ','PDF_URL','VIDEO_URL');
	if(count($arr) == count($columns))
	{
		$insertData = array_combine($columns,$arr);//这是数组的PHP内置函数 ，函数括号中的前一个数组的值为新数组的索引，后一个参数的值为新数组的值
		//var_dump($insertData);
		try {
			$mysql = new Mysql;
			$mysql->insert($table,$insertData);
			$mysql->close();
		} catch (Exception $e) {
			//error_log($e->getTrace());
			}
    }
}

function insertHomeworkInfo($arr)
{
	$tablename  = 't_homework_info';
	$columns = array('STUDENT_NUM','COURSE_ID','DEADLINE');
	if(count($arr) == count($columns))
	{
		$insertData = array_combine($columns,$arr);//这是数组的PHP内置函数 ，函数括号中的前一个数组的值为新数组的索引，后一个参数的值为新数组的值
		//var_dump($insertData);
		try {
			$mysql = new Mysql;
			$mysql->insert($table,$insertData);
			$mysql->close();
		} catch (Exception $e) {
			//error_log($e->getTrace());
			}
    }
}

function insertQuestionInfo()
{
	$columns = array();
	$sql = "INSERT INTO t_question_info (QUESTION_CONTENT,ANSWER) VALUES ()";
}
?>