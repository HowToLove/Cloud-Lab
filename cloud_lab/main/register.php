<?php
header('Content-type: text/json');
require_once('../main/common/function.php');
session_start();
$_SESSION['captcha']=$_POST['captcha'];
//比较验证码是否正确
$state=-3;
if(strtoupper($_POST['captcha'])==strtoupper($_SESSION['captcha'])){
	$arr['USER_NAME']=$_POST['username'];
	$arr['PASSWORD']=$_POST['password'];
	$arr['ID_VALUE']=$_POST['idnumber'];
	$arr['BIRTHDAY']=$_POST['birthday'];
	$arr['EMAIL']= $_POST['email'];
	
	//进行验证输入
	if(!regex($arr['USER_NAME'],'require')||
	   !regex($arr['PASSWORD'],'require')||
	   !regex($arr['EMAIL'],'require'))
	{
		$state=2;
	}   
	elseif(!regex($arr['ID_VALUE'],'idcard'))
		$state=3;
	elseif(!regex($arr['BIRTHDAY'],'date'))
		$state=4;
	elseif(!regex($arr['EMAIL'],'email'))
	    $state=5;
	    
	require_once ("../main/models/User.php");
	
    $user = new User;
	if($user->find($arr['USER_NAME'],'USER_NAME'))
	{
	    
		$state=6;
	}elseif($user->find($arr['EMAIL'],'EMAIL'))
	{
		$state=7;
	}elseif($user->find($arr['ID_VALUE'],'ID_VALUE'))
	{
		$state=8;
	}

	if($state===-3){
		try{
		    if($user->save($arr))
		    {
			  $state=1;
		    }else{
			  $state=0;
		    }
		 }catch(Exception $e)
		 {
		   $state = -2;
		 }
	} 
}else{
	$state=-1;
}
$registerStatus = array("registerStatus" => $state);
echo json_encode($registerStatus);

?>