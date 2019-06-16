<?php
require_once('../../includes/intialize.php');
if ($session->is_logged_in()==false) {
    redirect_to('login.php');
}
?>
<?php
$photos=Photographs::find_all();
?>
<?php include_layout('\header.php'); ?>
    
    <div class="menu">
    <?php
             if($message!=""){ 
                echo "<div class=\"danger\"><p>".$message."</p></div>";
            }
        ?>
        <h2>List Photos</h2>
        <table>
        <tr>
        <th>image</th>
        <th>filename</th>
        <th>caption</th>
        <th>size</th>
        <th>type</th>
        <th>comments</th>
        <th>&nbsp;</th>
        </tr>
        
        <?php
        $output="";
        foreach($photos as $photo){
            $output .= "<tr><td><img src=\"".$photo->return_path()."\" alt=\"not found\" width=\"100;\"  /></td>";
            $output .= "<td><p>".$photo->filename."</p></td>";
            $output .= "<td><p>".$photo->caption."</p></td>";
            $output .= "<td><p>".$photo->size."</p></td>";
            $output .= "<td><p>".$photo->type."</p></td>";
            $output .= "<td><p><a href=\"comments.php?id=".$photo->id."\">".count(($photo->comments()))."</a></p></td></tr>";
            $output .= "<td><a href=\"photo_delete.php?id=".$photo->id."\">delete this photo</a></td>";
            // $output .= "<hr><br><br>"; 
        }
        echo $output;
        ?>
        
        </table>
    </div>
    <a href="photo_upload.php">Upload photo from here</a>

  <?php include_layout('\footer.php');?>