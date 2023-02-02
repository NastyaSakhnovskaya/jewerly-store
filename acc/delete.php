<?php
session_start();

        include("../connect/connect.php");
        $product_id = $_GET['product_id'];
        $query="DELETE FROM `basket` WHERE `id`='$product_id'";
        $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        print "<script language='Javascript' type='text/javascript'>
        function reload(){top.location ='../basket.php'};
        setTimeout('reload()', 0);
        </script>";
   
?>