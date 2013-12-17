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
       /* $sql = 'INSERT INTO t_user_info(user_name,password,id_type,id_value,user_type,email,birthday) VALUES('.$arr['USER_NAME'].',"'.$arr['PASSWORD'].'","'.$arr['ID_TYPE'].'","'.$arr['ID_VALUE'].'",'.$arr['USER_TYPE'].',"'.$arr['EMAIL'].'",'.$arr['BIRTHDAY'].')';
        echo $sql;
        //$mysql  = new Mysql;
        $link = mysql_connect('localhost','root','root');
        mysql_select_db('cloud_lab',$link);
        if(!mysql_query($sql))
        {
            die('Error: ' . mysql_error());
        }
          return true;*/
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
}
?>