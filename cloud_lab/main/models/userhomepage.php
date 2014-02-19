<?php

/**
 * filename:userhomepage.php
 * @author <cwlseu@qq.com> 2014-2-17
 * @version 1.0
 * @description :������ȡ�û�����ϸ��Ϣ����ʾ��������ҳ��
 */

@require_once("getClassInfoById.php");

/**
 * ��ȡ�û��Ļ�����Ϣ
 * @param  String $userid   �û�id 
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
 * ��ȡ�û���صĿγ̵���Ϣ
 * @param  			$userid 	�û���id
 * @return array    $return		����ѧ������Ŀγ̵������Ϣ
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
 * ��ȡ��ʦ��ҳ����Ϣ
 * @param  [type] $userid [description]
 * @return [type]         [description]
 * "{
 *
 *		"usertype":"student",
 *		"info":{
 *		  "username":cwlseu,
 *		  "idtype":"���֤",
 *		  "idvalue":"123456789012345678",
 *		  "birthday":"2013-11-11",
 *		  "email":"cwlseu@qq.com"
 *		  "attendcourse":[{
 *		   "classname":"Oracle����",
 *		   "teacher":"������",
 *		   "classbegin":"2013-11-11",
 *		   "classend":"2014-11-11",
 *		   "grade":"0"
 *		   },{
 *		   "classname":"Oracle���",
 *		   "teacher":"������",
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
 * ��ȡѧ����ҳ����Ϣ
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