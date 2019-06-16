<?php 
require_once('../../includes/intialize.php');
include_layout('\header.php'); 
if ($session->is_logged_in()==false) {
    redirect_to('login.php');
}
if(!isset($_GET['id'])){
    redirect_to('list.php');
}else{
    $id=$database->escape_string($_GET['id']);
    $photo = Photographs::find_by_id($id);
    if(!isset($photo)){
        $session->message("Invalid id");
        redirect_to("list.php");
    }
    $comments= $photo->comments();
?>
    <div class="show-comment">
    <?php 
    foreach ($comments as $comment) {
    ?> <div><?php echo htmlentities($comment->author); ?></div>
        <div><?php echo htmlentities($comment->body);?></div>
        <div><a href="delete_comment.php?id=<?php echo $comment->id ;?>">delete comment</a></div>
    <?php    }  ?>
    </div>

<?php    
}
?>
<?php include_layout('\footer.php'); ?>