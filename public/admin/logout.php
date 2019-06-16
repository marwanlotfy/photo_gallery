<?php
require_once('../../includes/intialize.php');
if($session->is_logged_in()){
    $session->logout();
}
redirect_to('login.php');
?>
