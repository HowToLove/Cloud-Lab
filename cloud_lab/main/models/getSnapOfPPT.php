<?php
	/**
	@param $charpter
	@param $classId
	@param $lesson
	@return ppt和video的播放号序列
	*/
	function getSnapOfPPT($classid,$charpter,$lesson)
	{
		$slides;
		$vedio;
		$sql = "SELECT Detail.PIC_URL AS url,Detail.VIDEO_SECTION AS section 
		FROM t_ppt_info Info, t_ppt_det Detail,t_class_info Class
		WHERE Class.CLASS_ID = "."$classid"." AND Class.COURSE_ID = Info.COURSE_ID 
		AND Detail.PPT_ID = Info.PPT_ID AND Info.COURSE_CHARPTER = "."$charpter".
		" AND Info.LESSON_SEQ = "."$lesson ORDER BY PPT_PAGE_NUM ASC";
		
		$result = mysql_query($sql);
		$i = 0;
		while($row = mysql_fetch_array($result)){
			$slides[$i] = $row['url'];
			$vedio[$i++] = $row['section'];
		}
		$ret['snap'] = $slides;
		$ret['vedio'] = $vedio;
		mysql_free_result($result);	
		return $ret;
	}
	
	/**
	*@param $classid 	当前课程的信息之班级
	*@param $charpterId 当前课程的信息之章节
	*@param $lessonId 	当前课程的信息之课时
	*@return 			下一节课的信息
	*用来获取下一节课的信息
	*/
	function getNext($classId,$charpterId,$lessonId)
	{
		$next;
		//先比较当前课程节数与数据库中的该章节最大节数的大小
		$sql = 
	   "SELECT Detail.LESSON_SEQ 
		FROM t_class_info Class, t_course_det Detail
		WHERE Detail.COURSE_ID 		= Class.COURSE_ID 
		  AND Class.CLASS_ID   		= "."$classId"." 
		  AND Detail.CHARPTER_ID 	= ". "$charpterId";
		try {
			$result = mysql_query($sql);
			//echo "result is:".$result;
			$row = mysql_fetch_array($result);
			$maxLessonSEQ = $row[0];
			
			if($lessonId<$maxLessonSEQ)//如果小了就直接对lessonId+1
			{
				$next['charpter'] = $charpterId;
				$next['lesson'] = $lessonId+1;			
			} else {
				//否则判断是否是最后一章
				$sql = "SELECT COUNT(*) FROM t_class_info  Class, t_course_det  Detail
				WHERE Detail.COURSE_ID = Class.COURSE_ID 
				AND Class.CLASS_ID = "."$classId". 
				" AND Detail.CHARPTER_ID = "."$charpterId+1";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				if($row[0]>0){
					$next['charpter'] = $charpterId + 1;
					$next['lesson'] = 1;				
				}else{
					$next['charpter'] = $charpterId;
					$next['lesson'] = $lessonId;
				}
			}
			
			mysql_free_result($result);		
			return $next;

		} catch (Exception $e) {
			
		}
	}


	/**
	*@param $classid 	当前课程的信息之班级
	*@param $charpterId 当前课程的信息之章节
	*@param $lessonId 	当前课程的信息之课时
	*@return 			上一节课的信息
	*用来获取上一节课的信息
	*/
	function getPrev($classId,$charpterId,$lessonId)
	{
		$prev;
		//首先判断最后一节课是否>1
		if($lessonId>1){
			$prev['charpter'] = $charpterId;
			$prev['lesson'] = $lessonId-1;
		} else if($charper == 1){//最初的一节
			$prev['charpter'] = 1;
			$prev['lesson'] = 1;
		}else{
			$prev['charpter'] = $charpterId - 1;
			$temp = $charpterId - 1;
			//从数据库中找到上一章最大的一节
			$sql = "SELECT D.LESSON_SEQ
			FROM t_class_info C, t_course_det D
			WHERE C.COURSE_ID = D.COURSE_ID 
			AND C.CLASS_ID = "."$classId".
			" AND D.CHARPTER_ID = "."$temp";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$prev['lesson'] = $row['LESSON_SEQ'];
			//echo $sql;
		}
		//var_dump($prev);		
		return $prev;
	}

	/**
	 *@param $classid 	当前课程的信息之班级
	 *@param $charpterId 当前课程的信息之章节
	 *@param $lessonId 	当前课程的信息之课时
	 *@return 			下一节课的信息
	 *获取与本节课程相关的所以题目
	*/
	function getHomeworkOfLesson($classId,$charpterId,$lessonId)
	{
		$sql = 
		"SELECT TQuestion.QUESTION_CONTENT AS question ,
				TQuestion.ANSWER 		   AS ans
		FROM t_question_info TQuestion
		WHERE TQuestion.QUESTION_ID 
		in 
		   (
		    SELECT TRel.QUESTION_ID 
		    FROM t_homework_question_rel TRel 
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
	/**
	 *@param $classid 	当前课程的信息之班级
	 *@param $charpterId 当前课程的信息之章节
	 *@param $lessonId 	当前课程的信息之课时
	 *@return 	array(
	 *array("sourcename"=>"xxx.cpp","source"=>"#include<iostream> using std::cout; int main(){cout<<"HelloWorld!" return 1;},
	 *array("sourcename"=>"helloworld.cpp","source"=>"#include<iostream> using std::cout; int main(){cout<<"HelloWorld!" return 1;})
	 *)
	 *获取与本节课程相关的所以题目
	*/
	function getCodeExample($classId,$charpter,$lesson)
	{
		$sql = "";
	}
	/**
	 *@param $classid 	当前课程的信息之班级
	 *@param $charpterId 当前课程的信息之章节
	 *@param $lessonId 	当前课程的信息之课时
	 *@return 	url "xxx/xxxx/xxx"
	 *获取与本节课程相关的视频URL
	*/
	function getVideoUrl($classId,$charpter,$lesson)
	{
		$sql = "SELECT Info.VIDEO_URL AS url 
				FROM t_ppt_info Info,t_class_info Class
				WHERE Class.COURSE_ID 		= 	Info.COURSE_ID
				  AND Class.CLASS_ID 		=	$classId 
				  AND Info.COURSE_CHARPTER 	=	$charpter
				  AND Info.LESSON_SEQ 		=	$lesson 
				LIMIT 1";
		//echo $sql;
		try {
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			return $row["url"];
		} catch (Exception $e) {
			
		}
	}
	
?>