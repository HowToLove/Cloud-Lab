<?php
require_once "../main/models/User.php";
header('Content-type: text/json');

$username=$_POST['username'];
$password=$_POST['password'];
$stat = -1;

if($username == "")
{
	$stat = 0;
}
elseif($password == "")
{
	$stat = 1;
}
else
{ 
	$user = new User;
	$user = $user->hasRight($username,$password);
  
    if(!is_null($user)){
        $stat = 2;
        $_SESSION['USER_ID']    =   $user['USER_ID'];
        $_SESSION['USERNAME']   =   $user['USER_NAME'];
        $_SESSION['USER_TYPE']  =   $user['USER_TYPE'];
    }else{
        $stat = 3;
        
    }
}
$loginStatus = array("loginStatus" => $stat,"userType"=>$_SESSION['USER_TYPE']);
echo json_encode($loginStatus);
?>