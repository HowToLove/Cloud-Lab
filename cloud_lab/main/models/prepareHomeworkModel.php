<?php
   /**
	*@param $charpter
	*@param $classId
	*@param $lesson
	*@param $question=array(1,2,3,5,6) 问题题号数组
	*@return true save success false save failed
	*/
	function TsaveAssignHomework($classId,$charpter,$lesson,$question)
	{
		try {
			
			//create sql
			
			//execute sql 
			
		} catch (Exception $e) {
			var_dump($e->getTrace());
		}
	}
	/**
	 *@param $classid 	当前课程的信息之班级
	 *@param $charpterId 当前课程的信息之章节
	 *@param $lessonId 	当前课程的信息之课时
	 *@return 			下一节课的信息
	 *获取与本节课程相关的所以题目
	*/
	function getAllQuestionOfLesson($classId,$charpterId,$lessonId)
	{
		$sql = 
		"SELECT TQuestion.QUESTION_CONTENT AS question ,
				TQuestion.ANSWER 		   AS ans
		FROM t_question_info TQuestion
		WHERE TQuestion.QUESTION_ID 
		in 
		   (SELECT TRel.QUESTION_ID 
		    FROM t_question_lesson_rel TRel 
		    WHERE TRel.COURSE_CHARPTER=$charpterId
		    AND TRel.LESSON_SEQ =$lessonId
		    AND TRel.COURSE_ID =
				(
		    	SELECT Class.COURSE_ID 
		    	FROM t_class_info Class 
		    	WHERE CLASS_ID = $classId LImit 1
				)
		    )";
		try {
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$temp["question"]= $row['question'];
				$temp["answer"]  = $row['ans'];
				$query[] = $temp;
			}
			return $query;
		} catch (Exception $e) {
			
		}
	}
?>