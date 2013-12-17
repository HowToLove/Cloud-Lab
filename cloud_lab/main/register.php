<?php
header('Content-type: text/json');

//$_SESSION['captcha']=$_POST['rcaptcha'];
//比较验证码是否正确
session_start();
if(strtoupper($_POST['rcaptcha'])==strtoupper($_SESSION['captcha'])){
	$arr['USER_NAME']=$_POST['rusername'];
	$arr['PASSWORD']=$_POST['rpassword'];
	$arr['ID_VALUE']=$_POST['ridnumber'];
	$arr['BIRTHDAY']=$_POST['rbirthday'];
	$arr['EMAIL']= $_POST['remail'];
	//进行验证输入后
	var_dump($arr);
	require_once ("../main/models/User.php");
	$user = new User;
	if($user->save($arr)){
		echo 'register success';
	}else{
		echo 'register failed';
	}
}else{
	
}

?>