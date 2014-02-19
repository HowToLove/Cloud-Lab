<?php
	/**本文件用来保存教师用户的备课进度情况
	*/
	/**
	 *@param $charpter
	 *@param $classId
	 *@param $lesson
	 *@return $status (boolean)是否存储成功
	*/
	function saveProgress($classId,$charpter,$lesson)
	{
		$sql = "SELECT * FROM t_progress WHERE CLASS_ID = "."$classId";
		$result = mysql_query($sql);
		if(mysql_num_rows($result)<1){//如果该班级进度记录还未建立，则新建立一条记录
			$sql = "INSERT INTO t_progress 
			(CLASS_ID,PRE_CHARPTER_ID,PRE_LESSON_ID,ON_CHARPTER_ID,ON_LESSON_ID)
			VALUES ("."$classId".",1,1,1,1)";
			mysql_query($sql);
			//echo $sql;
		}
		$sql = "UPDATE t_progress 
		SET ON_CHARPTER_ID = "."$charpter".
		" , ON_LESSON_ID = "."$lesson".
		" WHERE CLASS_ID = "."$classId";
		$result = mysql_query($sql);
		//echo $sql;
		return mysql_affected_rows();
	}
?>