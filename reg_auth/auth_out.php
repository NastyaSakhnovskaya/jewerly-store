<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
$_SESSION['login']='';

$_SESSION['surname']='';

print "<script language='Javascript' type='text/javascript'>
 function reload(){top.location = '../index.php'};
 setTimeout('reload()', 0);
 </script>";
?>