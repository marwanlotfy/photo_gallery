<?php 
require_once('../../includes/intialize.php'); 
if ($session->is_logged_in()==false) {
    redirect_to('login.php');
}
if(!isset($_GET['id'])){
    redirect_to('list.php');
}else{
    $id=$database->escape_string($_GET['id']);
    $comment = Comment::find_by_id($id);
    if(!isset($comment)){
        $session->message("Invalid id of comment");
        redirect_to("list.php");
    }
    if($comment->delete()){
        $session->message("comment deleted successfuly");
        redirect_to("list.php");
    }
}
?>