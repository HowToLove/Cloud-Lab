<?php
/**
 * 本文件用来产生验证码
 *@filename: ./maim/common/validateCode.php
 *@author :<cwlseu@qq.com>
**/
 
/**
 *function：random
 *@return 生成随机字符串
 *@
 */
function random($num)
{
	$code='';
	for($i=0;$i
<$num;$i++)//生成验证码
	{
		switch(rand(0,2))
		{
			case 0:$code[$i]=chr(rand(48,57));break;//数字
			case 1:$code[$i]=chr(rand(65,90));break;//大写字母
			case 2:$code[$i]=chr(rand(97,122));break;//小写字母
		}
	}
	if(!isset($_SESSION)){
		session_start();
		$_SESSION["captcha"]=implode('',$code);
	}else{
		$_SESSION["captcha"]=implode('',$code);
	}
	
	return $code;
}
/**
 *function：createCode
 *@param $num 字符串的个数
 *@param $width 图片宽度
 *@param $height 图片高度
 *@return 生成随机字符串
 *@
 */
function createCode($num,$width,$height)
{
	$code = random($num);
	$image=imagecreate($width,$height);
	
	imagecolorallocate($image,200,200,200);  //背景颜色
	//生成干扰像素
	for($i=0;$i<80;$i++)
	{
		$dis_color=imagecolorallocate($image,rand(0,2555),rand(0,255),rand(0,255));
		imagesetpixel($image,rand(1,$width),rand(1,$height),$dis_color);
	}
	
	//打印字符到图像
	for($i=0;$i<$num;$i++)
	{
		$char_color=imagecolorallocate($image,rand(0,255),rand(0,255),rand(0,255));
		imagechar($image,30,($width/$num)*$i,rand(0,$height/$num*2),$code[$i],$char_color);
	}
	return $image;
}
function printCode()
{
	if(!isset($_SESSION)){
	session_start();
	}
	$num=4;//验证码个数
	$width=100;//验证码宽度
	$height=40;//验证码高度
	$image = createCode($num,$width,$height);
	header("Content-type:image/png");
	imagepng($image);//输出图像到浏览器
	imagedestroy($image);//释放资源
}
printCode();
?>