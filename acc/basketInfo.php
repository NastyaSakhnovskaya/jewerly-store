<?php
    echo "<link rel='stylesheet' href='style.css'>";
?>
<div class="basket__sector">
    <div class="products">
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

    $total_pages_sql = "SELECT COUNT(*) FROM `basket` WHERE `login`= '$login'";
    $result = mysqli_query($link ,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);


    $query = "SELECT * FROM `basket` INNER JOIN `product` ON `product_id` = `id_product` WHERE `login`= '$login' LIMIT $offset, $no_of_records_per_page";
    $res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if($res) {
        $rows = mysqli_num_rows($res); // количество полученных строк
        for ($i = 0 ; $i < $rows ; ++$i)
        {
            $row = mysqli_fetch_row($res);
            $product_id = $row[0];
            $title = $row[6];
            $img = $row[7];
            $price = $row[8];
            $metal = $row[9];
            $stone = $row[10];
            echo "<div class=\"product__item\">
            <img src=\"../$img\" class=\"product__img\">
            <div><p class='basket__text title'>$title</p><p class='basket__text'>$metal</p><p class='basket__text'>$stone</p></div>
            <p class='basket__text price'>$price BYN</p>
            <div>
            <a href='delete.php?product_id=$product_id' class='btn1 danger'>Удалить</a>
            <a href='orders_form.php?count=$product_id' class='btn1 secondary' target='_top'>Заказать</a>
            </div>
            </div>";
        }
    }

    $sum_sql = "SELECT `price` FROM `basket` INNER JOIN `product` ON `product_id` = `id_product` WHERE `login`= '$login'";
    $res_sum = mysqli_query($link, $sum_sql) or die("Ошибка " . mysqli_error($link));
    while($row = mysqli_fetch_array($res_sum)){
        $sum += $row[0];
    }
?>
</div>
    <div class="sum__info">
        <p class="title">Итого: <?php echo $sum?> BYN</p>
        <a class="btn" id="btn" href="orders_form.php?count=all" target="_top">Заказать</a>
    </div>
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
