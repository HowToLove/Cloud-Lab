<?php
	/**
	*@param $charpter
	*@param $classId
	*@param $lesson
	*@return ppt和video的播放号序列,以及每页ppt老师的备注信息
	*/
	function getSnapAndRemarkOfPPT($classId,$charpter,$lesson)
	{
		$slides;
		$vedio;
		$remarkTemp;
		$remark;
		$sql = "SELECT Detail.PIC_URL AS url,Detail.VIDEO_SECTION AS section 
		FROM t_ppt_info Info, t_ppt_det Detail,t_class_info Class
		WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
		AND Detail.PPT_ID = Info.PPT_ID AND Info.COURSE_CHARPTER = "."$charpter".
		" AND Info.LESSON_SEQ = "."$lesson ORDER BY PPT_PAGE_NUM ASC";
		//echo $sql;
		$result = mysql_query($sql);
		$i = 0;
		while($row = mysql_fetch_array($result)){
			$slides[$i] = $row['url'];
			$vedio[$i++] = $row['section'];			
		}
		$sql = "SELECT Remark.PPT_PAGE_NUM AS page,Remark.REMARK AS remark 
		FROM t_ppt_remark Remark,t_ppt_info Info,t_class_info Class
		WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
		AND Remark.PPT_ID = Info.PPT_ID AND Info.COURSE_CHARPTER = "."$charpter".
		" AND Info.LESSON_SEQ = "."$lesson";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$remarkTemp[$row['page']] = $row['remark'];		
		}

		for($i=0;$i<count($slides);$i++){
			if(array_key_exists($i+1,$remarkTemp))
				$remark[$i] = $remarkTemp[$i+1];
			else{
				$remark[$i] = null;
			}
		}

		$ret['snap'] = $slides;
		$ret['vedio'] = $vedio;
		$ret['remark'] = $remark;
		mysql_free_result($result);	
		return $ret;
	}


	/**
	*@param $classid 	当前课程的信息之班级
	*@param $charpterId 当前课程的信息之章节
	*@param $lessonId 	当前课程的信息之课时
	*@param $pagenum 	当前ppt 对应的页号
	*@param $remark     当前ppt的备注
	*@return 	true :save success false :save failed	
	*用来保存当前ppt的备注
	*/
	function savePPTRemarkPreClass($classId,$charpter,$lesson,$pagenum,$remark)
	{
		$sql = "SELECT Remark.PPT_ID AS PPT_ID FROM t_ppt_remark Remark,t_ppt_info Info,t_class_info Class 
		WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
		AND Remark.PPT_ID = Info.PPT_ID AND Info.COURSE_CHARPTER = "."$charpter".
		" AND Info.LESSON_SEQ = "."$lesson"." AND Remark.PPT_PAGE_NUM = "."$pagenum";
		$result = mysql_query($sql);
		if(mysql_num_rows($result)<1){//没有记录要新插入一条记录			
			$sql = "SELECT Info.PPT_ID AS PPT_ID FROM t_ppt_info Info,t_class_info Class 
			WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
			 AND Info.COURSE_CHARPTER = "."$charpter".
			" AND Info.LESSON_SEQ = "."$lesson";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$pptId = $row['PPT_ID'];
			$sql = "INSERT INTO t_ppt_remark (CLASS_ID,PPT_ID,PPT_PAGE_NUM,REMARK) 
			VALUES ($classId, $pptId, $pagenum, '$remark')";			
		} else{//有记录只要更新就行
			$row = mysql_fetch_array($result);
			$pptId = $row['PPT_ID'];
			$sql = "UPDATE t_ppt_remark SET REMARK = "."'$remark'".
			" WHERE PPT_ID = "."$pptId"." AND CLASS_ID = "."$classId".
			" AND PPT_PAGE_NUM = "."$pagenum";			
		}
		//echo $sql;
		$status = mysql_query($sql);
		return $status;
	}

	/**
	*@param $classid 	当前课程的信息之班级
	*@param $charpterId 当前课程的信息之章节
	*@param $lessonId 	当前课程的信息之课时
	*@param $preparation 本节课的备课信息
	*@return 	true :save success false :save failed	
	*用来保存当前课程的教案
	*/
	function savePreparationPreClass($classId,$charpter,$lesson,$preparation)
	{
		
	}
?>