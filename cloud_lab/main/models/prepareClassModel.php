<?php
	/**
	*@param $charpter
	*@param $classId
	*@param $lesson
	*@return ppt��video�Ĳ��ź�����,�Լ�ÿҳppt��ʦ�ı�ע��Ϣ
	*/
	function getSnapAndRemarkOfPPT($classId,$charpter,$lesson)
	{
		$slides;
		$video;
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
			$video[$i++] = $row['section'];			
		}
		$sql = "SELECT Remark.PPT_PAGE_NUM AS page,Remark.REMARK AS remark 
		FROM t_ppt_remark Remark,t_ppt_info Info,t_class_info Class
		WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
		AND Remark.PPT_ID = Info.PPT_ID AND Info.COURSE_CHARPTER = "."$charpter".
		" AND Info.LESSON_SEQ = "."$lesson";
		$result = mysql_query($sql);
		//echo $sql;
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
		$ret['video'] = $video;
		$ret['remark'] = $remark;
		mysql_free_result($result);	
		//var_dump($ret);
		return $ret;
	}


	/**
	*@param $classid 	��ǰ�γ̵���Ϣ֮�༶
	*@param $charpterId ��ǰ�γ̵���Ϣ֮�½�
	*@param $lessonId 	��ǰ�γ̵���Ϣ֮��ʱ
	*@param $pagenum 	��ǰppt ��Ӧ��ҳ��
	*@param $remark     ��ǰppt�ı�ע
	*@return 	true :save success false :save failed	
	*�������浱ǰppt�ı�ע
	*/
	function savePPTRemarkPreClass($classId,$charpter,$lesson,$pagenum,$remark)
	{		
		//�жϱ���remark�ı��뷽ʽ
		if(mb_detect_encoding($remark)=='UTF-8')
		{
			$remark2 = iconv('UTF-8','gb2312//IGNORE',$remark);
		}else{
			$remark2 = iconv(mb_detect_encoding($remark),'gb2312//IGNORE',$remark);
		}
		//��ѯ�Ƿ��Ѿ�����Ӧ�ı�ע��
		$sql = "SELECT Remark.PPT_ID AS PPT_ID FROM t_ppt_remark Remark,t_ppt_info Info,t_class_info Class 
		WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
		AND Remark.PPT_ID = Info.PPT_ID AND Info.COURSE_CHARPTER = "."$charpter".
		" AND Info.LESSON_SEQ = "."$lesson"." AND Remark.PPT_PAGE_NUM = "."$pagenum";
		try {
			mysql_query("set names 'gbk'");
			$result = mysql_query($sql);
			if(mysql_num_rows($result)<1){//û�м�¼Ҫ�²���һ����¼
				$sql = "SELECT Info.PPT_ID AS PPT_ID FROM t_ppt_info Info,t_class_info Class 
				WHERE Class.CLASS_ID = "."$classId"." AND Class.COURSE_ID = Info.COURSE_ID 
				 AND Info.COURSE_CHARPTER = "."$charpter".
				" AND Info.LESSON_SEQ = "."$lesson";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				$pptId = $row['PPT_ID'];
				$sql = "INSERT INTO t_ppt_remark (CLASS_ID,PPT_ID,PPT_PAGE_NUM,REMARK) 
				VALUES ($classId, $pptId, $pagenum, '$remark2')";			
			} else{//�м�¼ֻҪ���¾���
				$row = mysql_fetch_array($result);
				$pptId = $row['PPT_ID'];
				$sql = "UPDATE t_ppt_remark SET REMARK = "."'$remark2'".
				" WHERE PPT_ID = "."$pptId"." AND CLASS_ID = "."$classId".
				" AND PPT_PAGE_NUM = "."$pagenum";			
			}
			//echo $sql;
			mysql_free_result($result);
			
			try {
				$status = mysql_query($sql);
				return $status;
			} catch (Exception $e) {
				var_dump('Remark ������߸���ʧ��');
			}
		} catch (Exception $e) {
			var_dump($e->getTrace());
		}
	}



	/**
	*@param $classid 	��ǰ�γ̵���Ϣ֮�༶
	*@param $charpterId ��ǰ�γ̵���Ϣ֮�½�
	*@param $lessonId 	��ǰ�γ̵���Ϣ֮��ʱ
	*@return 	����:[1,2,3],��:[1,2,3]
	*���������Ӧ�γ̵���ҵ�����Լ��ο���	
	*/
	function getRelatedQuestions($classId,$charpter,$lesson)
	{
		$question;
		$answer;
		$sql = "SELECT Q.QUESTION_CONTENT AS question, Q.ANSWER AS answer 
		FROM t_question_info Q, t_question_lesson_rel R, t_class_info C 
		WHERE C.CLASS_ID = $classId AND C.COURSE_ID = R.COURSE_ID 
		AND R.QUESTION_ID = Q.QUESTION_ID AND R.COURSE_CHARPTER = $charpter 
		AND R.LESSON_SEQ = $lesson";
		mysql_query("set names 'GB2312'");
		$result = mysql_query($sql);
		$i = 0;
		while($row = mysql_fetch_array($result)){
			$question[$i] = iconv('gb2312//IGNORE','UTF-8',$row['question']);
			$answer[$i++] = iconv('gb2312//IGNORE','UTF-8',$row['answer']);
		}
		$ret['question'] = $question;
		$ret['answer'] = $answer;
		return $ret;
	}
	/**
	 *@param $classid 	��ǰ�γ̵���Ϣ֮�༶
	 *@param $charpterId ��ǰ�γ̵���Ϣ֮�½�
	 *@param $lessonId 	��ǰ�γ̵���Ϣ֮��ʱ
	 *@return 		[{����,��},{����,��},{����,��}]
	 {"questions":
		 [
		 {"question":"", "answer":""},
		 {"question":"", "answer":""}
		 ] 
	}
	 *��ȡ�뱾�ڿγ���ص�������Ŀ
	*/
	function getAllQuestionOfLesson($classId,$charpterId,$lessonId)
	{
		$sql = 
		"SELECT TQuestion.QUESTION_CONTENT AS question ,
				TQuestion.ANSWER 		   AS ans,
				TQuestion.QUESTION_ID AS id,
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
				$temp['id'] = $row['id'];
				$query[] = $temp;
			}
			return $query;
		} catch (Exception $e) {
			
		}
	}
	/**
	 *@param $classid 	��ǰ�γ̵���Ϣ֮�༶
	 *@param $charpterId ��ǰ�γ̵���Ϣ֮�½�
	 *@param $lessonId 	��ǰ�γ̵���Ϣ֮��ʱ
	 *@param $questionids ��ʦѡ�е������
	 *@return 	true OR false
	 *������ʦѡ�е�����
	*/
	function saveHomeworkList($classId,$charpterId,$lesson,$questionids,$deadline)
	{
		$status = false;
		$sql = "DELETE FROM t_homework_question_rel,
		WHERE HOMEWORK_ID IN (
			SELECT HOMEWORK_ID FROM t_homework_info  
			WHERE CLASS_ID = $classId AND COURSE_CHARPTER = $charpterId 
			AND LESSON_SEQ = $lesson)";
		//echo $sql;
		mysql_query($sql);
		
		$sql = "DELETE FROM t_homework_info WHERE CLASS_ID = $classId 
		AND COURSE_CHARPTER = $charpterId AND LESSON_SEQ = $lesson";
		mysql_query($sql);
		
		$sql = "INSERT INTO t_homework_info (CLASS_ID,COURSE_CHARPTER,LESSON_SEQ,DEADLINE) 
		VALUES ($classId,$charpterId,$lesson,'$deadline')";
		mysql_query($sql);
		//echo $sql;
		$homeworkId = mysql_insert_id();
		$questionNum = count($questionids);
		for($i = 0;$i<$questionNum;$i++){
			$questionId = $questionids[$i];
			$sql = "INSERT INTO t_homework_question_rel (HOMEWORK_ID, QUESTION_ID)
			VALUES ($homeworkId,$questionId)";
			//echo $sql;
			$status = mysql_query($sql);	
		}
		return true;
	}


   /**
	*@param $classid 	��ǰ�γ̵���Ϣ֮�༶
	*@param $charpterId ��ǰ�γ̵���Ϣ֮�½�
	*@param $lessonId 	��ǰ�γ̵���Ϣ֮��ʱ
	*@param $preparation ���ڿεı�����Ϣ
	*@return 	true :save success false :save failed	
	*�������浱ǰ�γ̵Ľ̰�
	*/
	function savePreparationPreClass($classId,$charpter,$lesson,$preparation)
	{
		$preparation = addslashes($preparation);
		if(mb_detect_encoding($preparation)=='UTF-8')
		{
			$preparation = iconv('UTF-8','gb2312//IGNORE',$preparation);
		}else{
			$preparation = iconv(mb_detect_encoding($preparation),'gb2312//IGNORE',$preparation);
		}
		
		$sql =  "SELECT Class.COURSE_ID AS courseId
		    	FROM t_class_info Class 
		    	WHERE CLASS_ID = '$classId'  
		    	Limit 1";
		
			$result = mysql_query($sql);
			$courseId ='';
			if(mysql_num_rows($result)<1)
			{
				var_dump("++++++++".mysql_num_rows($result)."++++++++");
			}else
			{
				$row = mysql_fetch_array($result);
				$courseId = $row['courseId'];
				//var_dump('courseId '.$courseId);	
			}
		//��ѯ�Ƿ��Ѿ�����Ӧ�ı�ע��
		$sql = "SELECT Presatation.PREPARATION_ID AS ID 
		FROM t_preparation Presatation
		WHERE  Presatation.COURSE_ID= '$courseId'
		AND Presatation.COURSE_CHARPTER = '$charpter' 
		AND Presatation.LESSON_SEQ = '$lesson'
		Limit 1";
		//echo "SELECT PREPARATION_ID: ".$sql."<br/>";
		try {
			mysql_query("set names 'gbk'");	
			$result = mysql_query($sql);
			$formalsql='';
			//var_dump("SELECT PREPARATION_ID RESULT: ".$result."<br/>");
			if(mysql_num_rows($result)<1){//û�м�¼Ҫ�²���һ����¼
				$formalsql = "INSERT INTO t_preparation
				(COURSE_ID,COURSE_CHARPTER,LESSON_SEQ,CONTENT) 
				 		VALUES ('$courseId', '$charpter', '$lesson', '$preparation')";	
			} else{//�м�¼ֻҪ���¾���
				$row = mysql_fetch_array($result);
				$presatationid = $row['ID'];
				$formalsql = "UPDATE t_preparation SET CONTENT ='$preparation'
				WHERE PREPARATION_ID = $presatationid ";
				//echo $formalsql;			
			}
			mysql_free_result($result);
			try {
				$status = mysql_query($formalsql);
				return $status;
			} catch (Exception $e) {
				var_dump('Presatation ������߸���ʧ��');
			}
		} catch (Exception $e) {
			var_dump($e->getTrace());
		}
	}
	/**
	 * ��ȡ�̰��ķ���
	 *@param $classid 	��ǰ�γ̵���Ϣ֮�༶
	 *@param $charpterId ��ǰ�γ̵���Ϣ֮�½�
	 *@param $lessonId 	��ǰ�γ̵���Ϣ֮��ʱ
	 *@return $preparation ���ڿεı�����Ϣ
	 */
	function getPreparationByClassIdCharpterLession($classid,$charpter,$lesson)
	{
		$preparation='';

		$sql = "SELECT Presatation.CONTENT AS content  
		FROM t_preparation As Presatation,t_class_info As Class
		WHERE  Class.CLASS_ID='$classid'
		AND Presatation.COURSE_ID= Class.COURSE_ID
		AND Presatation.COURSE_CHARPTER = '$charpter' 
		AND Presatation.LESSON_SEQ = '$lesson'
		Limit 1";

		try {
			$result = mysql_query($sql);
			if(mysql_num_rows($result)>=1){//û�м�¼Ҫ�²���һ����¼
				$row = mysql_fetch_array($result);
				$preparation['preparation']=$row['content'];
			}
			mysql_free_result($result);
			return $preparation;
		} catch (Exception $e) {
			var_dump($e->getTrace());
		}
		return $preparation;
	}

?>


