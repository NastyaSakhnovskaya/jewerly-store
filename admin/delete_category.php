<?php
session_start();
    include("../connect/connect.php");
    if($_GET['name']=="category") {
        $id = $_GET['id'];
        $query="DELETE FROM `category` WHERE `id_category`='$id'";
        $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        print "<script language='Javascript' type='text/javascript'>
        function reload(){top.location ='admin.php'};
        setTimeout('reload()', 0);
        </script>";
    }
    if($_GET['name']=="product") {
        $id = $_GET['id'];
        $query="DELETE FROM `product` WHERE `id_product`='$id'";
        $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        print "<script language='Javascript' type='text/javascript'>
        function reload(){top.location ='admin_product.php'};
        setTimeout('reload()', 0);
        </script>";
    }
?>