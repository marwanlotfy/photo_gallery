<?php
require_once('intialize.php');
class Comment extends DatabaseObject 
{
    public static $table_name="comments";
    public static $vars_table=array("id","photograph_id","created","body","author");
    public $id;
    public $photograph_id;
    public $created;
    public $body;
    public $author;
    public static function make($photograph_id,$body="",$author="anonymous")
    {
        if(!empty($photograph_id) && !empty($body) && !empty($author))
        {
        global $database;
        $comment = new Comment();
        $comment->photograph_id=(int)$photograph_id;
        $comment->body=$database->escape_string($body);
        $format="%Y-%m-%d %H:%M:%S";
        $comment->created=strftime($format,time());
        $comment->author=$database->escape_string($author);
        return $comment;
        }else{
            return false;
        }
    }
    public static function find_comments_on($photograph_id=0)
    {
        $photograph_id=(int)$photograph_id;
        global $database;
        $sql  = "SELECT * FROM ".self::$table_name;
        $sql .= " WHERE photograph_id=".$photograph_id;
        $sql .= " ORDER BY created ASC";
        $comments=self::find_by_sql($sql);
        return $comments;
    }
}
