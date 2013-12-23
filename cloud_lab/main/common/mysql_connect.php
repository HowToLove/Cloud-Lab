<?php
require_once('../main/config/dbconfig.php');
class Mysql{
   private  $conn;//一个非持久链接
   private  $db;  //一个数据库实例
   /**
   *@return 一个非持久链接
   */
   public function __construct()
   {
      try{
         $this->conn=mysql_connect(host,username,password);
         if($this->conn)
            $this->db = mysql_select_db(dbname,$this->conn);
      }catch(Exception $e)
      {
          var_dump($e->getTrace());
      }
   }
   public  function connection($p=false)
   { 
      try{
         if(!$p){
           $this->conn=mysql_connect(host,username,password) ;
         }else{
           $this->conn=mysql_pconnect(host,username,password); 
         }   
      }catch(Exception $e)
      {
         var_dump($e->getTrace());
      }
       
       return $this->conn;
        
   }
   /**
   *@return 如果成功则返回 true，失败则返回 false。
   */
   public  function close()
   {
       return mysql_close($this->conn);
   }
   /**
   *@param void
   *@return db 返回一个数据库的实例
   *
   */
   public  function getDatabase(){
       if($this->conn==null){
          $this->connection();
       }
       if($this->db==null){
           $this->db = mysql_select_db(dbname,$this->conn) or die ("不能连接到DB".mysql_error());
       }   
       return $this->db;
   }
   /**
   *@param $sql 一条查询语句
   *@return $result=array(
   *                     array(), array()
   *                      ); $result[i]为一条查询结果
   *
   */
   public function query($sql){
        $this->getDatabase();
        $result = mysql_query($sql,$this->conn);
        $return =array();
        while($row=mysql_fetch_array($result)){
            array_push($return,$row);
        }
        $this->close();
        return $return;
   }
   /**
   *@param $tablename
   *@param $condition 
   */
   public function find($tablename,$condition=null,$arr='*'){
        $sql='';
        if($arr=='*'){
        $sql ='SELECT * FROM '.$tablename.' ';
        }else{
        $sql ='SELECT  ';
           foreach ($arr as $key => $value) {
             $sql=$sql.' '.$value.' ,';
           }
           $sql = substr($sql,0,strlen($sql)-1);
           $sql=$sql.' FROM'.$tablename.' ';
        }
        if($condition==null){
          
        }else{
           $sql=$sql.' WHERE ';
           //
        }
   }
   /**
   * @param $string tablename 表名
   * @param $columes  columns 是tablename表的属性
   * @param $arr= array('key'=>'value');   
   *如果columns为null，那么必须是key与value的键值对的形式,而且key是table表中的属性名称
   * @return true 插入成功 else 插入失败
   */
   public function insert($tablename,$arr,$columns=null)
   {
      //construct the sql sentence
       $sql='';
       if($columns==null){
          $sql ='INSERT INTO '.$tablename.' (';
          foreach ($arr as $key => $value) 
          {
              $sql=$sql.' '.$key.',';
          }
          $sql = substr($sql,0,strlen($sql)-1);
          $sql=$sql.' ) VALUES('.' ';
          foreach ($arr as $key => $value) 
          {
              $sql=$sql.'" '.$value.'",';
          }
          $sql = substr($sql,0,strlen($sql)-1);
          $sql=$sql.' )';
       }else{
          $sql ='INSERT INTO '.$tablename.' (';
          foreach ($columns as $key => $value) 
          {
              $sql=$sql.' '.$value.',';
          }
          $sql = substr($sql,0,strlen($sql)-1);
          $sql=$sql.' ) VALUES('.' ';
          foreach ($arr as $key => $value) 
          {
              $sql=$sql.'" '.$value.'",';
          }
          $sql = substr($sql,0,strlen($sql)-1);
          $sql=$sql.' )';
       }
       if($this->db==null){
         $this->getDatabase();
       }
       //excute the sql sentence
       if(!mysql_query($sql,$this->conn))
       {
          die('Insert Error' . mysql_error());
       }else{
          return true;
       } 
   }
   /**
   * @param $string tablename 要更新的表名
   * @param $columes  columns 是tablename表的属性
   * @param $arr= array('key'=>'value');   
   *如果columns为null，那么必须是key与value的键值对的形式,而且key是table表中的属性名称
   * @return true 更新成功else 更新失败
   */
   public function update($tablename,$arr,$columns)
   {
       
   }
   
}	
?>