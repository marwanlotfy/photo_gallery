<?php 
require_once('../../includes/intialize.php');
if ($session->is_logged_in()==false) {
    redirect_to('login.php');
}
if(!isset($_GET['id'])){
    redirect_to('list.php');
}else{
    $id=$database->escape_string($_GET['id']);
    $photo = Photographs::find_by_id($id);
    if(isset($photo)){
        $session->message("Invalid id");
        redirect_to("list.php");
    }
    if($photo->delete()){
        $session->message($photo->filename."photo deleted successfuly");
        redirect_to("list.php");
    }
}