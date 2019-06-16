<?php
require_once('config.php');
class Database  
{
    private $connect;
    public $last_query;
    function __construct()
    {
        $this->open_connection();
    }
    private function open_connection()
    {
        $this->connect=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
        if(mysqli_connect_errno()){
            die('Database Connection failed:'.mysqli_connect_error().''.mysqli_connect_errno());
        }
    }
    public function close_connection()
    {
        if(isset($this->connect)){
        mysqli_close($this->connect);
        unset($this->connect);}
    }
    public function escape_string($sql)
    {
        return mysqli_real_escape_string($this->connect,$sql);
    }
    public function query($sql)
    {
        $this->last_query=$sql;
        $result=mysqli_query($this->connect,$sql);
        // $this->confirm_string($result);
        return $result;
    }
    private function confirm_string($result)
    {
        if(!$result){
            die('database query failed');
        }
    }
    public function num_rows($result)
    {
        return mysqli_num_rows($result);
    }
    public function fetch_array($result)
    { 
        return mysqli_fetch_assoc($result);
    }
    public function affected_rows()
    {
        return mysqli_affected_rows($this->connect);
    }
    public function insert_id()
    {
        return mysqli_insert_id($this->connect);
    }

}
$database = new Database();
$db =& $database;
// ? this code is used for debug
// echo $db->escape_string("hey my ' ");
?>