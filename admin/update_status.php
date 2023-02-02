<?php
    session_start();
    include("../connect/connect.php");
    $id = $_GET['id'];
    $login = $_GET['login'];
    $status = $_POST['status'];
    $query="UPDATE `orders` SET status='$status' WHERE `id_product`='$id' AND `login`='$login'";
    $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    print "<script language='Javascript' type='text/javascript'>
    function reload(){top.location ='admin_orders.php'};
    setTimeout('reload()', 0);
    </script>";
?>