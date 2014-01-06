<?php
/**
 *@param $classId
 *@return $array('charpter1'=>3,'charpter2'=>4)
 */
function getCourseDetail($classId)
{
	$charpter = null;
	
	$sql ="SELECT Detail.LESSON_SEQ AS lesson
		 FROM t_course_det Detail
		 WHERE Detail.COURSE_ID 
		 =(
		 SELECT Class.COURSE_ID AS courseid 
		 FROM t_class_info Class WHERE Class.CLASS_ID="."$classId"." limit 1) 
		 ORDER BY Detail.CHARPTER_ID ASC";
   // echo $sql;
	try {
		$result =  mysql_query($sql);
		$charpter = array();
		while($row=mysql_fetch_array($result)){
			$charpter[]=(int)$row['lesson'];
		}
		return $charpter;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
	
}
?>