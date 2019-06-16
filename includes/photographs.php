<?php 
require_once('intialize.php');
class Photographs extends  DatabaseObject
{
    public static $table_name="photographs";
    protected static $vars_table=array('id','filename','type','size','caption');
    public $id;
    public $filename;
    public $type;
    public $size;
    public $caption;
    private $tmp_path;
    private $upload_img_dir="..\img";
    public $upload_dir=SITE_ROOT."\public\img";
    public $errors=array();
    private $upload_errors=array(
        UPLOAD_ERR_OK =>"file uploaded",
        UPLOAD_ERR_INI_SIZE =>"file size greater than specified",
        UPLOAD_ERR_FORM_SIZE => "file size manpulated",
        UPLOAD_ERR_NO_FILE => "no file specifiy",
        UPLOAD_ERR_NO_TMP_DIR =>"NO TMP DIR",
        UPLOAD_ERR_PARTIAL => "FILE ISN'T COMPLETED ",
        UPLOAD_ERR_CANT_WRITE=> "CAN'T WRITE FILE TO THE DISK",
        UPLOAD_ERR_EXTENSION =>"CANT UPLAD THIS FILE"
    );
    public function attach_file($file)
    {
        if(!$file || empty($file) || !is_array($file)){
            $this->errors[]="no file was uploaded";
            return false;
        }elseif ($file['error'] != 0) {
            $this->errors[]=$this->upload_errors[$file['error']];
            // var_dump($this->upload_errors[$file['error']]);
            return false;
        }

        $this->filename=basename($file['name']);
        $this->tmp_path=$file['tmp_name'];
        $this->size=$file['size'];
        $this->type=$file['type'];
        return true;
    }
    private function safe_file()
    {
        if(strpos($this->filename,'.php')){
            return false;
        }
        return true;
    }
    public function return_path()
    {
        return $this->upload_img_dir."\\".$this->filename;
    }
    public function comments()
    {
        return Comment::find_comments_on($this->id);
    }
    public function save()
    {
        if(isset($this->id)){
            $this->update();
        }else{
            if(!empty($this->errors)){
                return false;
            }
            if (strlen($this->caption) > 255 ) {
                $this->errors[]="the caption is too long";
                return false;
            }
            if(empty($this->filename) || empty($this->tmp_path)){
                $this->errors[]="this file location is not avaliable";
                return false;
            }
            $location = $this->upload_dir."\\".$this->filename;
            if(file_exists($location)){
                $this->errors[]="this file can't be uploaded";
                return false;
            }
            if(!$this->safe_file()){
                $this->errors[]="this file can't be uploaded";
                return false;
            }
            if(move_uploaded_file($this->tmp_path,$location)){
                if($this->create()){
                    unset($this->tmp_path);
                    return true;
                }
            }else{
                $this->errors[]="the file upload failed";
                return false;
            }
        }
    }
}
