<?php
require_once('config.php');

if (isset($_GET['logout'])) {
    $_SESSION['auth_state'] = false;
    unset($_SESSION['userdata']);
    redirect('login.php');
}

if(!checkLogin()){
    redirect('login.php');
}else{
    redirect('manager.php'. '?p=');
}
