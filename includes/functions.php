<?php 
include('intialize.php');
// function __autoload($class_name)
// {
//     $class_name=strtolower($class_name);
//     $path= "{$class_name}.php";
//     if (file_exist($path)) {
//         require_once($path);
//     }else{
//         die("class:{$class_name} does not found");
//     }
// }
function redirect_to($location)
{
    header("LOCATION:{$location}");
}
function include_layout($template)
{
    include(SITE_ROOT."\public\layout".$template);
}
function log_action($action,$message="")
{
    $now=strftime("%d/%m/%Y %H:%M:%S | ",time());
    $content=$now.$action." : ".$message."\r\n";
    if ($handle=fopen(SITE_ROOT."\logs\log.txt",'a')) {
        fwrite($handle,$content);
        fclose($handle);
    }
}