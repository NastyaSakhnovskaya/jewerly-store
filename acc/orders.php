<?php
    session_start();
    $login = $_SESSION['login'];
    $phone = $_POST['phone'];
    $adress = $_POST['adress'];
    $id = $_SESSION['count'];
    include("../connect/connect.php");
    foreach($_SESSION['id_order_product'] as $item) {
        $query_insert = " INSERT INTO orders (login, id_product, phone, adress)  VALUES ('$login','$item','$phone', '$adress')";
        $result_insert=mysqli_query($link, $query_insert) or die("Ошибка " . mysqli_error($link));

        if($_SESSION['count'] == 'all') {
            $query_delete = "DELETE FROM `basket`  WHERE `login`='$login'";
        } else {
            $query_delete = "DELETE FROM `basket`  WHERE `id`='$id' AND `login`='$login'";
        }
        
        $result_delete = mysqli_query($link, $query_delete) or die("Ошибка " . mysqli_error($link));

        print "<script language='Javascript' type='text/javascript'>
        function reload(){top.location ='../basket.php'};
        setTimeout('reload()', 0);
        </script>";
    }
?>