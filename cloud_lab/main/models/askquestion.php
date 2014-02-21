<?php
/**
 * 
 * filename:../main/models/askquestion.php
 * @author <cwlseu@qq.com> 2014-2-19
 * @version 1.0
 *  本文件用来处理学生提出问题以及问题的存储，获取，参看等功能
 *  主要针对't_ask_info'进行的一系列操作
 */
/**
 *插入问的问题，
 * @param  [type] $pptid              ppt的ID号
 * @param  [type] $ppturl             ppt的存放地址
 * @param  [type] $classid            class的ID
 * @param  [type] $studentid          提问者的ID
 * @param  [type] $askquestioncontent 问题内容
 * @param  [type] $site               array('top1'=> , 'top2'=> , 'left1'=> , 'left2'=>);
 * @return [type]                     该问题插入数据后的ID
 * @unfinished 数据格式的验证
 */
function insertAskedQuestion($pptid,$classid,$studentid,$askquestioncontent,$site=null,$ppturl='')
{
	
	$ppturl=mysql_real_escape_string($ppturl);
	$askquestioncontent=mysql_real_escape_string($askquestioncontent);
	
	$top1=$top2=$left1=$left2 = -1;
	$insert_a_askquestionsql = '';
	if(isset($site))
	{
		$top1  = $site['top1'];
		$top2  = $site['top2'];
		$left1 = $site['left1'];
		$left2 = $site['left2'];
	}
	$insert_a_askquestionsql="INSERT INTO t_ask_info (PPT_ID,PPT_URL,CLASS_ID,STUDENT_ID,ASK_CONTENT,TOP1,TOP2,LEFT1,LEFT2)VALUES('$pptid','$ppturl','$classid','$studentid','$askquestioncontent','$top1','$top2','$left1','$left2')";

	mysql_query($insert_a_askquestionsql);
	//echo $insert_a_askquestionsql;
	return mysql_insert_id();
}

/**
 * 更新用户回答的问题
 * @param  [type] $askid  提问的问题的id
 * @param  [type] $answer 回答的内容
 * @return 更新影响的行数
 */
function insert_question_answer($askid,$answer)
{
	$answer=mysql_real_escape_string($answer);
	$insert_a_askquestionanswersql="UPDATE t_ask_info SET ASK_ANSWER='$answer' WHERE ASK_ID='$askid'";
	mysql_query($insert_a_askquestionanswersql);
	return mysql_affected_rows();
}
/**
 * 查找有相关关键字的问题
 * @param  [type] $question 关键字
 * @return [type]           问题序列
 */
function find_alllike_question($question)
{
	$findSql = "SELECT ASK_ID AS askid,ASK_CONTENT AS question,ASK_ANSWER AS answer 
						FROM t_ask_info 
						WHERE ASK_CONTENT 
						like '%$question%'
				UNION SELECT ASK_CONTENT AS question,ASK_ANSWER AS answer 
						FROM t_ask_info 
						WHERE ASK_ANSWER 
						like '%$question%'";
	//echo $findSql;
	$return  = array();
	try {
		//mysql_query("set names 'gbk'");
		$result_answer = mysql_query($findSql);
		while($row = mysql_fetch_assoc($result_answer))
		{
			array_push($return, $row);
		}
		mysql_free_result($result_answer);	
		return $return;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
	return $return ;
}
/**
 * 通过pptid，classid查找相应的askquestion information
 * @param  [type] $pptid   [description]
 * @param  [type] $classid [description]
 * @return one or a group question and its detail information
 */
function find_oneppt_question($pptid,$classid)
{
	$findQuestionSql = "SELECT ASK_ID AS askid,QUESTION_CONTENT AS question,ASK_ANSWER AS answer,USER_NAME as student 
	FROM t_ask_info ,t_user_info 
	WHERE PPT_ID = '$pptid'
	AND CLASS_ID = '$classid'
	AND t_ask_info.STUDENT_ID = t_user_info.USER_ID
	";
	$returnresult = array();
	try {
		$result = mysql_query($findQuestionSql);
	
		while($row = mysql_fetch_array($result))
		{
			array_push($returnresult,$row);
		}
		
		return $returnresult;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
	return $returnresult;	
}
/**
 * 通过pptid，classid查找相应的askquestion information
 * @param  [type] $pptid   [description]
 * @param  [type] $classid [description]
 * @return one or a group question and its detail information
 */
function find_student_question($studentid,$classid)
{
	$findQuestionSql = "SELECT ASK_ID AS askid,ASK_CONTENT AS question,ASK_ANSWER AS answer,COURSE_NAME AS course,COURSE_CHARPTER as chapter,LESSON_SEQ as lesson 
	FROM t_ask_info ,t_ppt_info,t_course_info
	WHERE STUDENT_ID= '$studentid'
	AND CLASS_ID = '$classid'
	AND t_ppt_info.COURSE_ID=t_course_info.COURSE_ID
	AND t_ask_info.PPT_ID = t_ppt_info.PPT_ID
	";
	$returnresult = array();
	try {
		$result = mysql_query($findQuestionSql);
	
		while($row = mysql_fetch_assoc($result))
		{
			array_push($returnresult,$row);
		}
		
		return $returnresult;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
	return $returnresult;	
}
/**
 * 通过classid查找某个class的所有问题
 * @param  [type] $classid [description]
 * @return [type]          [description]
 */
function find_class_question($classid)
{
	$findQuestionSql = "SELECT ASK_ID AS askid,QUESTION_CONTENT AS question,ASK_ANSWER AS answer 
	FROM t_ask_info  
	WHERE CLASS_ID = '$classid'
	";
	$returnresult = array();
	try {
		$result = mysql_query($findQuestionSql);
	
		while($row = mysql_fetch_array($result))
		{
			array_push($returnresult,$row);
		}
		
		return $returnresult;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
	return $returnresult;	
}
?>