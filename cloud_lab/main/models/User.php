<?php

/** 
 * This is the model class for table "{{user_info}}".
 *
 * The followings are the available columns in table '{{user_info}}':
 * @property string $USER_ID
 * @property string $USER_NAME
 * @property string $PASSWORD
 * @property integer $ID_TYPE
 * @property string $ID_VALUE
 * @property integer $USER_TYPE
 * @property string $EMAIL
 * @property string $BIRTHDAY
 * @property string $TIMESTAMP
 *
 * The followings are the available model relations:
 * @property AskInfo[] $askInfos
 * @property ClassInfo[] $classInfos
 * @property ClassUserRel[] $classUserRels
 * @property HomeworkResponseRel[] $homeworkResponseRels
 */
include('../main/common/mysql_connect.php');
class User 
{
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_user_info';
	}

	public function authenticate($attribute,$params)
    {
       
    }
    
	//给密码进行md5加密
    public function encypt($pass){
       return md5($pass);
    }
    
    public function hasRight($username,$password){      
        $sql = "select PASSWORD from " . 
        	$this->tableName().
        	' where USER_NAME="'.
        	$username.'"'; 
        $mysql = new Mysql;
        $row = $mysql->query($sql);
        if($row!=null &&$row[0]["PASSWORD"]==$this->encypt($password)){
            return true;
        }else{
            return false;
        }
		return false;   
    }
    public function save($arr)
    {
        $arr = $this->beforeSave($arr);
        $mysql=new Mysql;
        return $mysql->insert($this->tableName(),$arr);
    }
    /**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
    public function beforeSave($arr){
       $arr['ID_TYPE']=1;
       $arr['USER_TYPE']=1;
       $arr['PASSWORD']=$this->encypt($arr['PASSWORD']);  
       return $arr;
    }
    /**
     * 使用正则验证数据
     * @access public
     * @param string $value  要验证的数据
     * @param string $rule 验证规则
     * @return boolean
     */
    protected function regex($value,$rule) {
        $validate = array(
            'require'   =>  '/.+/',
            'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'integer'   =>  '/^[-\+]?\d+$/',
            'date'      =>  '/^\d{4}\-\d{1,2}-\d{1,2}$/',
            'idcard'    =>  '/^\d{14}(\d{4}|(\d{3}[xX])|\d{1}$/'
        );
        // 检查是否有内置的正则表达式
        if(isset($validate[strtolower($rule)]))
            $rule       =   $validate[strtolower($rule)];
        return preg_match($rule,$value)===1;
    }
    /**
    *@return true 验证数据成功否则false
    */
    public function rules($arr)
    {
       if(regex($arr['USER_NAME'],'require')&&regex($arr['PASSWORD'],'require')&&regex($arr['EMAIL'],'require'))
        {
            return false;
        }   
        elseif(regex($arr['ID_VALUE'],'idcard'))
            return false;
        elseif(regex($arr['BIRTHDAY'],'date'))
            return false;
        elseif(regex($arr['EMAIL'],'email'))
            return false;
        }
}
?>