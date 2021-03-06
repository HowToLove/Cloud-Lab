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
    //tablename
    private static  $tablename='t_user_info';

    //sql array
    private $sql =array(
    'USER'      =>  "SELECT * from t_user_info WHERE USER_NAME =",
    'EMAIL'     =>  "SELECT USER_ID from t_user_info WHERE EMAIL =",
    'ID_VALUE'  =>  "SELECT USER_ID from t_user_info WHERE ID_VALUE =",
    'USERNAME'  =>  "SELECT USER_ID from t_user_info WHERE USER_NAME ="
    );
    /**
    *a instance of Mysql
    */
    private $mysqlController;
    
    public function __construct()
    {
       $this->mysqlController=new Mysql;
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return User::$tablename;
	}

	//给密码进行md5加密
    public function encypt($pass)
    {
       return md5($pass);
    }
    /**
    *@param $username 
    *@param $password 
    *@return true :该用户有权访问 反之为false
    */
    public function hasRight($username,$password){      
        $sql=$this->sql['USER'].'"'.trim($username).'" limit 1';//"$username" 是必要的 
        $row = $this->mysqlController->query($sql);
        if($row!=null && trim($row[0]['PASSWORD'])==$this->encypt($password)){
           // var_dump($row[0]);
            return $row[0];

        }else{
            return null;
        } 
    }
    /**
    *@param arr= array('USER_NAME'=>'ss',..)
    *@return true save success
    */
    public function save($arr)
    {
        $arr = $this->beforeSave($arr);
        if($arr!=false)
        {
            return $this->mysqlController->insert($this->tableName(),$arr);
        }else{
            return false;
        }
        
    }
    /**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
    public function beforeSave($arr)
    {
       if($this->rules($arr))
       {
           $arr['ID_TYPE']=1;
           $arr['USER_TYPE']=1;
           $arr['PASSWORD']=$this->encypt($arr['PASSWORD']);  
           return $arr;
       }
       return false;
       
    }
    /**
     * 使用正则验证数据
     * @access public
     * @param string $value  要验证的数据
     * @param string $rule 验证规则
     * @return boolean
     */
    protected function regex($value,$rule)
    {
        $validate = array(
            'require'   =>  '/.+/',
            'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'integer'   =>  '/^[-\+]?\d+$/',
            'date'      =>  '/^\d{4}\-\d{1,2}-\d{1,2}$/',
            'idcard'    =>  '/^\d{14}(\d{4}|(\d{3}[xX])|\d{1})$/'
        );
        // 检查是否有内置的正则表达式
        if(isset($validate[strtolower($rule)]))
            $rule       =   $validate[strtolower($rule)];
        return preg_match($rule,$value)===1;
    }
    /**
    *@return true 验证数据成功否则false
    */
    protected function rules($arr)
    {
       if(!regex($arr['USER_NAME'],'require')||
       !regex($arr['PASSWORD'],'require')||
       !regex($arr['EMAIL'],'require'))
        {
            return false;
        }   
        elseif(!regex($arr['ID_VALUE'],'idcard'))
            return false;
        elseif(!regex($arr['BIRTHDAY'],'date'))
            return false;
        elseif(!regex($arr['EMAIL'],'email'))
            return false; 
        elseif($this->find($arr['USER_NAME'])||
        $this->find($arr['EMAIL'],'EMAIL')||
        $this->find($arr['ID_VALUE'],'ID_VALUE'))
            return false;
        return true;
    }
    /**
    *@param $key 属性名称
    *@param $value 属性值
    */
    public function find($value,$key='')
    {
        $querysql = '';

        if($key==''||strtoupper(trim($key))==strtoupper('USER_NAME'))
        {
            $querysql=$this->sql['USERNAME'].$value;
        }elseif(strtoupper(trim($key))==strtoupper('ID_VALUE'))
        {
             $querysql=$this->sql['ID_VALUE'].$value;
        }elseif(strtoupper(trim($key))==strtoupper('EMAIL'))
        {
            $querysql=$this->sql['EMAIL'].$value;
        }
        else
        {
            $querysql = "select * from " . 
            $this->tableName().
            ' where '.$key.'="'.$value.'"'; 
        }
        $row = $this->mysqlController->query($querysql);
        if($row==null){
            return false;
        }else{
            return true;
        }
    }
    /**
    *
    */
}
?>