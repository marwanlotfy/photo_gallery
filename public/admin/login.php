<?php
require_once('../../includes/intialize.php');
if ($session->is_logged_in()) {
    redirect_to('index.php');
}
if (isset($_POST['submit'])) {
    $username=trim($_POST['user_name']);
    $password=trim($_POST['password']);
    
    $user=User::auth($username,$password);
    if($user){
        $session->login($user);
        $log->log_action('user logged in',"username is {$user->username}");
        redirect_to('index.php');

    }else{
        $message="Username/password didn't match";
        
    }

}

?>
<?php include_layout('\header.php'); ?>
    </div>
    <div class="menu">
        <h2>Log In</h2>
        <form class="login-form" action="login.php" method="post">
            User Name: <input type="text" name="user_name" ><br><br>
            PassWord: <input type="password" name="password" ><br><br>
            <input type="submit"  name="submit" value="Log In">
            <?php if($message){ ?>
            <div class="danger">
            <p>
            <?php 
            echo $message; 
            $message=null;
            ?>
            </p>
            </div>
            <?php } ?>
    </div>

        </form>
        
<?php include_layout('\footer.php');?>