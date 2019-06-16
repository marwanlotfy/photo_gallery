<?php
require_once('database.php');
class DatabaseObject 
{
    public static $table_name="";
    protected static $vars_table=array();
    public static function find_all()
    {
        global $database;       
        $sql="SELECT * FROM ".get_called_class()::$table_name;
        $objects=get_called_class()::find_by_sql($sql);
        return $objects;

    }
    public static function find_by_id($id=0)
    {
        global $database;
        $id_safe=(int)$id;
        $sql="SELECT * FROM ".get_called_class()::$table_name." WHERE id={$id_safe} LIMIT 1 ";
        $object=get_called_class()::find_by_sql($sql);
        return !empty($object) ? array_shift($object) : false ;
    }
    public static function find_by_sql($sql="")
    {
        global $database;
        $result=$database->query($sql);
        $object_array=array();
        if(isset($result)){
        while ($result_set=$database->fetch_array($result)) {
            $object_array[]=get_called_class()::istantiate($result_set);
        }
        return $object_array;
        }else{
            return null;
        }
    }
    private static function istantiate($record)
    {
        $object=new static;
        foreach ($record as $attribute => $value) {
            if($object->has_attribute($attribute)){
                $object->$attribute=$value;
            }
        }
        return $object;
        
    }
    private function has_attribute($attribute)
    {
        $vars= $this->attirbutes();
        return array_key_exists($attribute,$vars);
    }
    protected function attirbutes()
    {
        // // var_dump(get_object_vars($this));
        // return get_object_vars($this);
        $attributes=array();
        $vars=get_called_class()::$vars_table;
        foreach($vars as $var){
            if(property_exists($this,$var)){
                $attributes[$var]=$this->$var;
            }
        }
        return $attributes;
    }
    protected function sanitized_attributes()
    {
        global $database;
        $clean_att=array();
        $att=$this->attirbutes();
        foreach ($att as $key => $value) {
            $clean_att[$key]=$database->escape_string($value);
        }
        // var_dump($clean_att);
        return $clean_att;
    }
    protected function id_striped_attributes()
    {
        $att=$this->sanitized_attributes();
        $striped_att=array();
        foreach ($att as $key => $value) {
            if($key!="id"){
                $striped_att[$key]=$value;
            }
        }
        return $striped_att;
    }
    public static function count_records()
    {
        global $database;
        $sql="SELECT COUNT(*) FROM ".get_called_class()::$table_name;
        $result = $database->query($sql);
        $res= $database->fetch_array($result);
        return array_shift($res);

    }
    protected function create()
    {
        global $database;
        $sql  ="INSERT INTO ".get_called_class()::$table_name." ";
        $sql .=" (";
        $att=$this->id_striped_attributes();
        $sql .= join(",",array_keys($att));
        $sql .= ") ";
        $sql .=" VALUES ('";
        $sql .= join("','",array_values($att));
        $sql .= "')";
        // echo $sql;
        if($database->query($sql)){
            $this->id=$database->insert_id();
            return true;
        }else{
            
            var_dump($sql);
            return false;
        }
    }
    protected function update()
    {
        global $database;
        $sql  ="UPDATE ".static::$table_name." SET ";
        $attributes=$this->id_striped_attributes();
        $attribute_pairs=array();
        foreach ($attributes as $key => $value) {
            $attribute_pairs[]="{$key}='{$value}'";
            }
        $sql .=join(" , ",$attribute_pairs);
        $sql .=" WHERE id={$database->escape_string($this->id)}";
        $database->query($sql);
        // echo $sql;
        return   ($database->affected_rows()==1) ? true : false ;
    }
    public function delete()
    {
        global $database;
        $sql  ="DELETE FROM ".get_called_class()::$table_name;
        $sql .=" WHERE id={$database->escape_string($this->id)} ";
        $sql .=" LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows()==1) ? true : false ;
    }
    public function save()
    {
        return   (isset($this->id)) ? $this->update() : $this->create() ;
    }
}
