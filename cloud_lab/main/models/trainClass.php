<?php
/**
 * file: /models/tainClass.php
 * @author <cwlseu@qq.com>
 */

//table: t_train_lesson_rel
/**
 * 获取某们课程某章节的某课的上机训练
 * @param  [type] $courseid 课程号
 * @param  [type] $chapter  章节号
 * @param  [type] $lesson   节号
 * @return [type]           训练的号
 */
function getCourseTrainId($courseid,$chapter,$lesson)
{
	$sql = "SELECT TRAIN_ID AS trainid 
			FROM t_train_lesson_rel AS Rel
			WHERE Rel.COURSE_ID = '$courseid'
			AND Rel.COURSE_CHARPTER = '$chapter'
			AND Rel.LESSON_SEQ = '$lesson'
	";
	try {
		$result =array();
		$sqlresult = mysql_query($sql);
		while($row = mysql_fetch_assoc($sqlresult))
		{
			$result[]=$row['trainid'];
		}
		return $result;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
}

/**
 * 获取某们课程某章节的某课的上机训练
 * @param  [type] $courseid 课程号
 * @param  [type] $chapter  章节号
 * @param  [type] $lesson   节号
 * @return [type]           训练的信息
 */
function getCourseTrain($courseid,$chapter,$lesson)
{
	$trains =  getCourseTrainId($courseid,$chapter,$lesson);
	try {
		$result =array();
		foreach ($trains as $key => $train) {
    		$sql = "SELECT TRAIN_NAME as trainname,TRAIN_TYPE as traintype,TRAIN_DESC as description 
    		FROM t_train_info 
    		WHERE TRAIN_ID = '$train'
    		Limit 1";
    		$sqlresult = mysql_query($sql);
    		$result[]=mysql_fetch_assoc($sqlresult);
    		mysql_free_result($sqlresult);
		}
		return $result;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
}
?>