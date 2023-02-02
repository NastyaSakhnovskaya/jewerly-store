<?php
session_start();
    if(!empty($_SESSION['login'])) {
        include("../connect/connect.php");
        $login = $_SESSION['login'];
        $product_id = $_GET['product_id'];
        $query="INSERT INTO `basket` (product_id, login)  VALUES ('$product_id','$login')";
        $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($result) {
            print "<script language='Javascript' type='text/javascript'>
            function reload(){top.location ='../index.php'};
            setTimeout('reload()', 0);
            </script>";
        }
    }
    else {
        print "<script language='Javascript' type='text/javascript'>
            alert('Registration');
            function reload(){top.location ='../index.php'};
            setTimeout('reload()', 0);
            </script>";
    }
?>