<?php
require_once('../../includes/intialize.php');
if ($session->is_logged_in()==false) {
    redirect_to('login.php');
}
?>
<?php
// $message="";
if (isset($_POST['submit'])) {
    $photo = new Photographs();
    $photo->caption=$_POST['caption'];
    if(!$photo->attach_file($_FILES['file_upload'])){
        $message=join("<br>",$photo->errors);
    }
    if(!$photo->save()){
        $message=join("<br>",$photo->errors);
        
    }else{
        $session->message("Photo uploaded successfuly");
        redirect_to("list.php");
    }
    // var_dump($message);
}
?>
<?php include_layout('\header.php'); ?>
    
    <div class="menu">
        <h2>Upload Photos</h2>
        <?php
             if($message!=""){ 
                echo "<div class=\"danger\"><p>".$message."</p></div>";
            }
        ?>
        <form action="photo_upload.php" enctype="multipart/form-data" method="post">
            Enter the caption :<input type="text" name="caption"/><br><br>
            <input type="file" name="file_upload"/><br><br>
            <input type="submit" name="submit" value="upload"/><br><br>
        </form>
    </div>

  <?php include_layout('\footer.php');?>