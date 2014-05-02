<?php
/**
 * 本文件用来处理提交作业和教师修改作业的模块
 * @author <cwlseu@qq.com>
 * @version 1.0
 * 
 */

/**
 * student handin the homework 
 * @param  [type] $homeworkid the id of the homework
 * @param  [type] $questionid question id 
 * @param  [type] $studentid  student id 
 * @param  string $answer     the question's answers
 * @return the id in the homeworktable 
 */
function handin_question($homeworkid,$questionid,$studentid,$answer='')
{
	$sql = "INSERT INTO t_homework_response_rel (t_homework_response_rel.HOMEWORK_ID,t_homework_response_rel.QUESTION_ID,
		   	    t_homework_response_rel.STUDENT_ID,t_homework_response_rel.ANSWER_CONTENT)
			VALUES('$homeworkid','$questionid','$studentid','$answer')";
	//echo $sql;
	mysql_query($sql);
	return mysql_insert_id();
}
	/**
	* 参看某次作业的的信息
	* @param 	$classid 		当前课程的信息之班级
	* @param 	$charpterId 	当前课程的信息之章节
	* @param 	$lessonId 		当前课程的信息之课时
	* @param 	$studentid 		学生信息ID
	* @return             		本次作业的情况
	*/
function checkhomeworkremark($classid,$charpter,$lesson,$studentid)
{
	if(!isset($studentid))
	{
		$studentid = $_SESSION['USER_ID'];
	}
	
	
}
/**
 * check for the class all the homework which is belong to the student
 * @param  [type] $classid   class's identification number
 * @param  [type] $studentid student identification number
 * @return [type]            all the homework and the question and id 
 */
function checkallhomeworkremark($classid,$studentid)
{
	if(!isset($studentid))
	{
		$studentid = $_SESSION['USER_ID'];
	}
	$selectSql = "SELECT Rel.HOMEWORK_ID AS homeworkid,
		Question.QUESTION_ID AS questionid,
		Question.QUESTION_CONTENT as question,
		Rel.ANSWER_CONTENT as myanswer,
		Question.ANSWER as referenceanswer
	FROM t_question_info AS Question,
		t_homework_response_rel AS Rel,
		t_homework_info  AS Homework
	WHERE  	Rel.QUESTION_ID = Question.QUESTION_ID
	AND		Homework.HOMEWORK_ID = Rel.HOMEWORK_ID
	AND		Homework.CLASS_ID = '$classid' 
	AND 	Rel.STUDENT_ID 	= '$studentid'
	ORDER BY Rel.HOMEWORK_ID,Question.QUESTION_ID
	";
	/*"SELECT Rel.HOMEWORK_ID ,
		Question.QUESTION_ID,
		Question.QUESTION_CONTENT,
		Rel.ANSWER_CONTENT,
		Question.ANSWER
	FROM t_question_info As Question,
		t_homework_response_rel as Rel
	WHERE　
		Rel.HOMEWORK_ID　in (
							SELECT HOMEWORK_ID 
							FROM t_homework_info 
							WHERE CLASS_ID = '$classid'
							)
		AND Rel.STUDENT_ID = '$studentid'
		AND  Rel.QUESTION_ID = Question.QUESTION_ID";*/
	
	$result = mysql_query($selectSql);
	$questions=array();
	
	while($row =mysql_fetch_assoc($result))
	{
		array_push($questions,$row);
	}
	return $questions; 
} 
/**
 * [teacherGetHomeworkIdByHomeworkId description]
 * @param  int $homeworkid 	作业的id号
 * @return array  				所有该做次作业布置的试题
 */
function teacherGetHomeworkIdByHomeworkId($homeworkid)
{
	$sql = 
	"SELECT TQuestion.QUESTION_ID AS id,
			TQuestion.QUESTION_CONTENT AS question ,
			TQuestion.ANSWER 		   AS answer
	FROM t_question_info TQuestion
	WHERE TQuestion.QUESTION_ID
	IN (
		SELECT Rel.QUESTION_ID AS qid 
 		FROM t_homework_question_rel Rel 
 		WHERE Rel.HOMEWORK_ID='$homeworkid'		
	)";
	echo $sql ;
	$questions=array();
	try{
		$result = mysql_query($sql);
		while($row =mysql_fetch_assoc($result))
		{
			array_push($questions,$row);
		}
		return $questions; 
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
	return null;
}
/**
 * teacher submit the remark about a homework question
 * @param  [type] $teacherid  教师的ID号
 * @param  [type] $studentid  学生的ID号
 * @param  [type] $questionid 问题的ID号
 * @param  [type] $remark     问题的批注
 * @return [type]             插入成功或者失败
 */
function teacher_submit_check_info($teacherid,$studentid,$questionid,$remark='')
{
	
	return false;
}
/**
 * teacher update the remark about a homework question
 * @param  [type] $teacherid  教师的ID号
 * @param  [type] $studentid  学生的ID号
 * @param  [type] $questionid 问题的ID号
 * @param  [type] $remark     问题的批注
 * @return [type]             更新或者插入成功或者失败
 */
function teacher_update_check_info($teacherid,$studentid,$questionid,$remark='')
{
	return false ;
}
?>