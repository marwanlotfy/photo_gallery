<?php
require_once("../includes/intialize.php");
?>
<?php include_layout('\public_header.php'); ?>
<?php
if(!isset($_GET['id'])){
    redirect_to("index.php");
}else{
    $id = $database->escape_string($_GET['id']);
    $photo =Photographs::find_by_id($id);
    if(!isset($photo)){
        redirect_to("index.php");
    }
    echo "<a href=\"index.php\">back</a>";
    echo "<img src=\"img\\".$photo->filename."\" alt=\"".$photo->filename."\"/>";
    echo "<br> Caption : ".$photo->caption;
}
if (isset($_POST['submit'])) {
    $author=$database->escape_string(trim($_POST['author']));
    $body=$database->escape_string(trim($_POST['body']));
    $comment=Comment::make($photo->id,$body,$author);
    if ($comment->save()) {
        # code...
    }else{
        $message="there was an error preventing the comment from uploaded";
    }
}else{
    $author="";
    $body="";
}
?>
<?php
$comments=Comment::find_comments_on($photo->id);
?>
<div class="show-comment">
<?php 
foreach ($comments as $comment) {
    ?> <div><?php echo htmlentities($comment->author); ?></div>
        <div><?php echo htmlentities($comment->body);?></div>
<?php    }  ?>
</div>
<form action="photo_show.php?id=<?php echo $photo->id; ?>" method="post" class="comment-form">
    Your Name: <input type="text" name="author" value="<?php echo $author; ?>" /><br><br>
    Your Comment: <textarea name="body" cols="40" rows="8" ><?php echo $body; ?></textarea><br><br>
    <input type="submit" name="submit" value="submit comment">
</form>

<?php include_layout('\footer.php'); ?>