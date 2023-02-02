<?php
    echo "<link rel='stylesheet' href='style.css'>";
?>

<div class="order__sector">
    <?php
        session_start();
        include("../connect/connect.php");
        $login = $_SESSION['login'];

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 2;
        $offset = ($pageno-1) * $no_of_records_per_page;
    
        $total_pages_sql = "SELECT COUNT(*) FROM `orders` WHERE `login`= '$login'";
        $result = mysqli_query($link ,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);
    

        $query = "SELECT * FROM `orders` WHERE `login`= '$login' LIMIT $offset, $no_of_records_per_page";
        $res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($res) {
            $rows = mysqli_num_rows($res); // количество полученныхстрок
            for ($i = 0 ; $i < $rows ; ++$i)
            {
                $row = mysqli_fetch_row($res);
                $product_id = $row[2];
                $status = $row[5];
                $adress = $row[4];
                $query_second =  "SELECT * FROM `product` WHERE `id_product`= '$product_id'";
                $result = mysqli_query($link, $query_second) or die("Ошибка " . mysqli_error($link));
                if($result) {
                    $row1 = mysqli_fetch_row($result);
                    $title = $row1[2];
                    $img = $row1[3];

                    echo "<div class=\"product__item\">
                    <div class='basket__sector'>
                    <img src=\"../$img\" class=\"order__img\">
                    <div class='order__sector'><p class='basket__text title'>$title</p><p class='basket__text'>Адрес доставки:$adress</p></div></div>
                    <div class='order_sector'><p class='basket__text price'>Статус заказа:</p><p>$status</p></div>
                
                    </div>";
                }
            }
        }
    ?>
</div>  
<ul class="pagination">
        <li><a href="?pageno=1"><<</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><</a>
        </li>
        <li><?php echo $pageno."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";?> </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">></a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">>></a></li>
    </ul>

   
