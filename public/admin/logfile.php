<?php
require_once('../../includes/intialize.php');
require_once('../../includes/functions.php');
if ($session->is_logged_in()==false) {
    redirect_to('login.php');
}
if(isset($_GET['clear']) && $_GET['clear']==true){
   $log->clear_log();
   redirect_to("logfile.php");
}?>
<?php include_layout('\header.php'); ?>
    
    <div class="menu">
        <h2>log</h2>
        <a style="margin:2em;"href="index.php">back</a> 
        <div class="log">
            
        <?php
        $log->show_log();
        echo "<br><br>";
        echo "<a href=\"logfile.php?clear=true\">clear log<a/>";
        ?>
        </div>
    </div>

<?php include_layout('\footer.php');?>