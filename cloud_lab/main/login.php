<?php
require_once ("../main/models/User.php");
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
	$user = new User();
    if($user->hasRight($username,$password)){
        $stat = 2;
    }else{
        $stat = 3;
    }
}
$loginStatus = array("loginStatus" => $stat);
echo json_encode($loginStatus);
?>