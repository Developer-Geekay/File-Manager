<?php 
session_start();
$userData = array(
    'user_id'=> '',
    'user_type'=> '',
    'username'=> '',
    'email'=> '',
);
$_SESSION['userdata'] = $userData;
$_SESSION['auth_state'] = false;
header("Location: index.php");
?>