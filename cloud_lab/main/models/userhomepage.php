<?php

/**
 * filename:userhomepage.php
 * @author <cwlseu@qq.com> 2014-2-17
 * @version 1.0
 * @description :用来获取用户的详细信息，显示到个人主页中
 */

@require_once("getClassInfoById.php");

/**
 * 获取用户的基本信息
 * @param  String $userid   用户id 
 * @return           
 *         
 */
function getUserBaseInfoById($userid)

{
	$sql = "SELECT USER_NAME As username, 
					ID_TYPE AS idtype,
					ID_VALUE AS idvalue,
					EMAIL AS email,
					BIRTHDAY AS birthday	
	FROM t_user_info AS User
	WHERE User.USER_ID='$userid'
	Limit 1";

	try {
		$result = mysql_query($sql);
		while(mysql_num_rows($result)>=1)
		{
			return mysql_fetch_assoc($result);
		}
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}

	return null;
}



/**
 * 获取用户相关的课程的信息
 * @param  			$userid 	用户的id
 * @return array    $return		返回学生参与的课程的相关信息
 */

function getUserAttendCourseInfoById($userid)

{
	$sql = "SELECT 	Class.CLASS_NAME as classname,
					User.USER_NAME as teacher,
					Class.CLASS_BEGIN as classbegin,
					Class.CLASS_END as classend,
					Rel.GRADE as grade
	FROM t_user_info As User,
		t_class_info AS Class,
		t_class_user_rel AS Rel
	WHERE Rel.USER_ID='$userid'
		AND Rel.CLASS_ID = Class.CLASS_ID
		AND Class.TEACHER_ID = User.USER_ID
	";
	//echo $sql;
	$return = array();
	try {
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			 array_push($return,$row);
		}
		return $return;
	} catch (Exception $e) {
		var_dump($e->getTrace());
	}
}

/**
 * 获取教师主页的信息
 * @param  [type] $userid [description]
 * @return [type]         [description]
 * "{
 *
 *		"usertype":"student",
 *		"info":{
 *		  "username":cwlseu,
 *		  "idtype":"身份证",
 *		  "idvalue":"123456789012345678",
 *		  "birthday":"2013-11-11",
 *		  "email":"cwlseu@qq.com"
 *		  "attendcourse":[{
 *		   "classname":"Oracle基础",
 *		   "teacher":"刘伯温",
 *		   "classbegin":"2013-11-11",
 *		   "classend":"2014-11-11",
 *		   "grade":"0"
 *		   },{
 *		   "classname":"Oracle提高",
 *		   "teacher":"王明川",
 *		   "classbegin":"2013-11-11",
 *		   "classend":"2014-11-11",
 *		   "grade":"0"
 *		   },]}
 *		}"
 */

function teacherHomePageInfo($userid)
{
	$userinfo =array();
	$row =getUserBaseInfoById($userid);
	$row['classes']= getClassInfoById($userid);
	$userinfo['usertype']="teacher";
	$userinfo['info']=$row;
	return $userinfo;
}

/**
 * 获取学生主页的信息
 * @param  [type] $userid [description]
 * @return [type]         [description]
 */

function studentHomePageInfo($userid)
{
	$userinfo =array();
	$row = getUserBaseInfoById($userid);
	$row['classes']= getUserAttendCourseInfoById($userid);
	$userinfo['usertype']="student";
	$userinfo['info']=$row;
	return $userinfo;
}

?>