<?php
	/**
	*@usertype teacher
	*@param $userId 用户的ID号
	*@return array 包含该用户所教授的课程
	*/
	function getClassInfoById($userId)
	{
		$classInfo;
		
		$sql = "SELECT Class.CLASS_ID AS classid, Class.CLASS_NAME AS classname,
		 Course.COURSE_NAME AS coursename, Course.COURSE_IMAGE AS imgurl,
		 Course.COURSE_DESC AS description 
		 FROM t_class_info Class, t_course_info Course
		 WhERE Class.teacher_id = ". "$userId".
		 " AND Course.COURSE_ID = Class.COURSE_ID";

		$result =  mysql_query($sql);
		$classInfo=array();
		if(mysql_num_rows($result)<=0){
			return $classInfo;//空值表示出错
		}

		$i = 0;
		while($row=mysql_fetch_array($result)){
			$classInfo[$i]['classid'] = $row['classid'];
			$classInfo[$i]['classname'] = $row['classname'];
			$classInfo[$i]['coursename'] = $row['coursename'];
			$classInfo[$i]['imgurl'] = $row['imgurl'];
			$classInfo[$i]['progress'] = getProgressByClassId($classInfo[$i]['classid']);
			$classInfo[$i]['description'] = $row['description'];
			$classInfo[$i++]['studentsnum'] = getStudentNumByClassId($row['classid']);
		}
		mysql_free_result($result);	
		return $classInfo;
	}
	/**
	*@param $classid
	*@return 课程进度
	*
	*/
	function getProgressByClassId($classId)
	{
		$progress;
		
		$sql = "SELECT ON_CHARPTER_ID AS charpter, ON_LESSON_ID AS lesson 
		FROM t_progress
		WHERE CLASS_ID = "."$classId";
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		$next = getNext($classId,$row['charpter'],$row['lesson']);
		$progress['charpter'] = $next['charpter'];
		$progress['lesson'] =$next['lesson'];
		$progress['percent'] = getPercentileByClassId($classId); 
		mysql_free_result($result);	
		return $progress; 
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
		$sql = "SELECT Detail.LESSON_SEQ FROM t_class_info AS Class, t_course_det AS Detail
		WHERE Detail.COURSE_ID = Class.COURSE_ID AND Class.CLASS_ID = "."$classId".
		" AND Detail.CHARPTER_ID = ". "$charpterId";
		try {
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result));
			{
				$maxLessonSEQ = $row[0];
			}
			
			if($lessonId<$maxLessonSEQ)//如果小了就直接对lessonId+1
			{
				$next['charpter'] = $charpterId;
				$next['lesson'] = $lessonId+1;			
			} else {//否则判断是否是最后一章
				$sql = "SELECT COUNT(*) FROM t_class_info AS Class, t_course_det AS Detail
				WHERE Detail.COURSE_ID = Class.COURSE_ID AND Class.CLASS_ID = "."$classId". 
				" AND Detail.CHARPTER_ID = "."$charpterId+1";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				if($row[0]>0){
					$next['charpter'] = $charpterId;
					$next['lesson'] = $lessonId;									
				}else{
					$next['charpter'] = $charpterId + 1;
					$next['lesson'] = 1;
				}
			}

			mysql_free_result($result);		
			return $next;

		} catch (Exception $e) {
			var_dump($e->getTrace());
		}
	}

	function getStudentNumByClassId($classId)
	{
		$sql = "SELECT COUNT(*) FROM t_class_user_rel WHERE CLASS_ID = "."$classId";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		    mysql_free_result($result);	
			return $row[0];
		}
	}

	function getPercentileByClassId($classId)
	{
		$sql = "SELECT SUM(Detail.LESSON_SEQ) FROM t_course_det Detail, t_class_info Class 
		WHERE Detail.COURSE_ID = Class.COURSE_ID AND Class.CLASS_ID = "."$classId";

		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$totalNum = $row[0];
		$sql = "SELECT SUM(Detail.LESSON_SEQ) FROM t_course_det Detail,t_class_info Class, t_progress Progress 
		WHERE Detail.COURSE_ID = Class.COURSE_ID AND Class.CLASS_ID = "."$classId".
		" AND Class.CLASS_ID = Progress.CLASS_ID AND Detail.CHARPTER_ID < Progress.ON_CHARPTER_ID";
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$currentLessonNum = $row[0];
		$sql = "SELECT ON_LESSON_ID FROM t_progress WHERE CLASS_ID = "."$classId";
		mysql_free_result($result);	
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$currentLessonNum += $row[0];
		mysql_free_result($result);	
		return $currentLessonNum/$totalNum;
	}
?>