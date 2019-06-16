<?php
require_once('database.php');
// require_once('functions.php');
class User extends DatabaseObject {
    public static $table_name="users";
    protected static $vars_table=array('id','username','firstname','lastname','password');
    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $password;
    // public static function find_all()
    // {
    //     global $database;       
    //     $sql="SELECT * FROM ".self::$table_name;
    //     $users=self::find_by_sql($sql);
    //     return $users;

    // }
    // public static function find_by_id($id=0)
    // {
    //     global $database;
    //     $id_safe=(int)$id;
    //     $sql="SELECT * FROM ".self::$table_name." WHERE id={$id_safe} LIMIT 1 ";
    //     $user=self::find_by_sql($sql);
    //     return !empty($user) ? array_shift($user) : false ;
    //     // $result= $database->query($sql);
    //     // if($result){
    //     // $result_set= $database->fetch_array($result);
    //     // return self::istantiate($result_set);
    //     // }else{
    //     //     return false;
    //     // }
    // }
    // public static function find_by_sql($sql="")
    // {
    //     global $database;
    //     $result=$database->query($sql);
    //     $object_array=array();
    //     if(isset($result)){
    //     while ($result_set=$database->fetch_array($result)) {
    //         $object_array[]=self::istantiate($result_set);
    //     }
    //     return $object_array;
    //     }else{
    //         return null;
    //     }
    // }
    // private static function istantiate($record)
    // {
    //     $object=new self;
    //     // $object->username=$record['user_name'];
    //     // $object->firstname=$record['first_name'];
    //     // $object->lastname=$record['last_name'];
    //     // $object->password=$record['password'];
    //     // $object->id=$record['id'];
    //     foreach ($record as $attribute => $value) {
    //         if($object->has_attribute($attribute)){
    //             $object->$attribute=$value;
    //         }
    //     }
    //     return $object;
        
    // }
    // private function has_attribute($attribute)
    // {
    //     $vars=get_object_vars($this);
    //     return array_key_exists($attribute,$vars);
    // }
    public function full_name()
    {
        if (isset($this->firstname)&&isset($this->lastname)) {
            return $this->firstname ." ". $this->lastname . "<br><br>";
        }else{
            return null;
        }
    }
    public static function auth($username,$password)
    {
        global $database;
        $username=$database->escape_string($username);
        $password=$database->escape_string($password);
        $sql ="SELECT * FROM users WHERE username='{$username}' AND password='{$password}' LIMIT 1";
        $result_array=self::find_by_sql($sql);
        return  !empty($result_array) ? array_shift($result_array) : false ;
    }
    // protected function create()
    // {
    //     global $database;
    //     $sql  ="INSERT INTO ".self::$table_name." ";
    //     $sql .=" (username, firstname, lastname, password) ";
    //     $sql .=" VALUES ('".$database->escape_string($this->username)."', '";
    //     $sql .= $database->escape_string($this->firstname)."', '";
    //     $sql .= $database->escape_string($this->lastname)."', '";
    //     $sql .= $database->escape_string($this->password)."')";
    //     echo $sql;
    //     if($database->query($sql)){
    //         $this->id=$database->insert_id();
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }
    // protected function update()
    // {
    //     global $database;
    //     $sql  ="UPDATE ".self::$table_name." SET ";
    //     $sql .="username='{$database->escape_string($this->username)}' , ";
    //     $sql .="firstname='{$database->escape_string($this->firstname)}' , ";
    //     $sql .="lastname='{$database->escape_string($this->lastname)}' , ";
    //     $sql .="password='{$database->escape_string($this->password)}'  ";
    //     $sql .=" WHERE id={$database->escape_string($this->id)}";
    //     $database->query($sql);
    //     echo $sql;
    //     return   ($database->affected_rows()==1) ? true : false ;
    // }
    // public function delete()
    // {
    //     global $database;
    //     $sql  ="DELETE FROM ".self::$table_name;
    //     $sql .=" WHERE id={$database->escape_string($this->id)} ";
    //     $sql .=" LIMIT 1";
    //     $database->query($sql);
    //     return ($database->affected_rows()==1) ? true : false ;
    // }
    // public function save()
    // {
    //     return   (isset($this->id)) ? $this->update() : $this->create() ;
    // }
}
?>