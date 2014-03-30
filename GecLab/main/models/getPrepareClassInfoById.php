<?php
@require_once('getClassInfoById.php');
	/**
	*@usertype teacher
	*@param $userId 用户的ID号
	*@return array 包含该用户所教授的课程
	*/
	function getPrepareClassInfoById($userId)
	{		
		$classInfo;
		
		$sql = "SELECT Class.CLASS_ID AS classid, Class.CLASS_NAME AS classname,
		 Course.COURSE_NAME AS coursename, Course.COURSE_IMAGE AS imgurl,
		 Course.COURSE_DESC AS description 
		 FROM t_class_info Class, t_course_info Course
		 WhERE Class.teacher_id = ". "$userId".
		 " AND Course.COURSE_ID = Class.COURSE_ID";

		$result =  mysql_query($sql);

		if(mysql_num_rows($result)<=0){
			return $classInfo;//空值表示出错
		}

		$i = 0;
		while($row=mysql_fetch_array($result)){
			$classInfo[$i]['classid'] = $row['classid'];
			$classInfo[$i]['classname'] = $row['classname'];
			$classInfo[$i]['coursename'] = $row['coursename'];
			$classInfo[$i]['imgurl'] = $row['imgurl'];
			$classInfo[$i]['progress'] = getPrepareProgressByClassId($classInfo[$i]['classid']);
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
	function getPrepareProgressByClassId($classId)
	{
		$progress;
		
		$sql = "SELECT PRE_CHARPTER_ID AS charpter, PRE_LESSON_ID AS lesson 
		FROM t_progress
		WHERE CLASS_ID = "."$classId";
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		$next = getNext($classId,$row['charpter'],$row['lesson']);
		$progress['charpter'] = $next['charpter'];
		$progress['lesson'] =$next['lesson'];
		$progress['percent'] = getPreparePercentileByClassId($classId); 
		mysql_free_result($result);	
		return $progress; 
	}

	function getPreparePercentileByClassId($classId)
	{
		$sql = "SELECT SUM(Detail.LESSON_SEQ) FROM t_course_det Detail, t_class_info Class 
		WHERE Detail.COURSE_ID = Class.COURSE_ID AND Class.CLASS_ID = "."$classId";

		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$totalNum = $row[0];
		$sql = "SELECT SUM(Detail.LESSON_SEQ) FROM t_course_det Detail,t_class_info Class, t_progress Progress 
		WHERE Detail.COURSE_ID = Class.COURSE_ID AND Class.CLASS_ID = "."$classId".
		" AND Class.CLASS_ID = Progress.CLASS_ID AND Detail.CHARPTER_ID < Progress.PRE_CHARPTER_ID";
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$currentLessonNum = $row[0];
		$sql = "SELECT PRE_LESSON_ID FROM t_progress WHERE CLASS_ID = "."$classId";
		mysql_free_result($result);	
		
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		$currentLessonNum += $row[0];
		mysql_free_result($result);	
		return round($currentLessonNum/$totalNum,2);
	}
?>