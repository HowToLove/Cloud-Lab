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
?>