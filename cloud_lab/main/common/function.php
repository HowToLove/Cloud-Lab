<?php
/**
 * 使用正则验证数据
 * @access public
 * @param string $value  要验证的数据
 * @param string $rule 验证规则
 * @return boolean
 */
function regex($value,$rule) {
    $validate = array(
        'require'   =>  '/.+/',
        'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
        'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
        'currency'  =>  '/^\d+(\.\d+)?$/',
        'number'    =>  '/^\d+$/',
        'zip'       =>  '/^\d{6}$/',
        'integer'   =>  '/^[-\+]?\d+$/',
        'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
        'english'   =>  '/^[A-Za-z]+$/',
        'date'      =>  '/^\d{4}\-\d{1,2}-\d{1,2}$/',
        'idcard'	=>	'/^\d{14}(\d{4}|(\d{3}[xX])|\d{1})$/'
    );
    // 检查是否有内置的正则表达式
    if(isset($validate[strtolower($rule)])){
    	$rule       =   $validate[strtolower($rule)];
    } 
    return preg_match($rule,$value)===1;
}
/**
 * 自定义异常处理
 * @param string $msg 异常消息
 * @param string $type 异常类型 默认为ThinkException
 * @param integer $code 异常代码 默认为0
 * @return void
 */
function throw_exception($msg, $type='Exception', $code=0) {
    if (class_exists($type, false))
        throw new $type($msg, $code);
    else
        var_dump("Exception ???");        // 异常类型不存在则输出错误信息字串
}
?>