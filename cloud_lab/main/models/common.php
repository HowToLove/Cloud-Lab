<?php
/**
 *@param $classid 	当前课程的信息之班级
 *@param $charpterId 当前课程的信息之章节
 *@param $lessonId 	当前课程的信息之课时
 *@return  该班级的该章节的某刻时时对应的作业ID号
 */
function getHomeworkId($classid,$charpter,$lesson)
{
	$sql = "SELECT t_homework_info.HOMEWORK_ID as id
			FROM t_homework_info
			WHERE t_homework_info.CLASS_ID ='$classid' 
			AND t_homework_info.COURSE_CHARPTER ='$charpter'
			AND t_homework_info.LESSON_SEQ = '$lesson'
			Limit 1";
		try {
				$result = mysql_query($sql);
				while($row =  mysql_fetch_assoc($result))
				{
					return $row['id'];
				}
			} catch (Exception $e) {
				var_dump($e->getTrace());
			}
		return -1;
}
/**
 *@param $classid 	当前课程的信息之班级
 *@param $charpterId 当前课程的信息之章节
 *@param $lessonId 	当前课程的信息之课时
 *@return  该班级的该章节的某刻时时对应的PPT的ID号
 */
function getPPTId($classid,$charpter,$lesson)
{
	$sql = "SELECT t_ppt_info.PPT_ID as id
			FROM t_ppt_info,t_class_info
			WHERE t_ppt_info.COURSE_ID =t_class_info.COURSE_ID
			AND t_class_info.CLASS_ID = '$classid'
			AND t_ppt_info.COURSE_CHARPTER ='$charpter'
			AND t_ppt_info.LESSON_SEQ = '$lesson'
			Limit 1";
		try {
				$result = mysql_query($sql);
				while($row =  mysql_fetch_assoc($result))
				{
					return $row['id'];
				}
			} catch (Exception $e) {
				var_dump($e->getTrace());
			}
		return -1;
}
?>