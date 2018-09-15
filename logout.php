<?php include('dbconn.php');
session_destroy();
setcookie('username',$_REQUEST['username'],time()-5);
setcookie('password',$_REQUEST['password'],time()-5);
header('Location:first.php');
?>