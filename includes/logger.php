<?php
require_once('intialize.php');
class Logger  
{
    private $log_file=SITE_ROOT.'\logs\log.txt';
    public function log_action($action,$message='')
    {
        $now=strftime("%d/%m/%Y %H:%M:%S | ",time());
        $content=$now.$action." : ".$message."\r\n";
        if ($handle=fopen(SITE_ROOT."\logs\log.txt",'a')) {
            fwrite($handle,$content);
            fclose($handle);
        }
    }
    public function clear_log()
    {
        unlink($this->log_file);
        log_action('clearlog','log cleared successfuly');
    }
    public function show_log()
    {
        $handle=fopen($this->log_file,'r');
        $content=fread($handle,filesize($this->log_file));
        $content=nl2br($content);
        echo $content;
    }
    public function set_log($path)
    {
        $this->log_file=$path;
    }
}
$log=new Logger();
?>
