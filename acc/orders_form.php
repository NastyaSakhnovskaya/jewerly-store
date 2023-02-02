
<html>
    <head>
        <title>Jewerly store</title>
        <link rel='stylesheet' href='../css/reg.css'>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
        <?php
            session_start();
            if(isset($_POST['submit'])) {
                $login = $_SESSION['login'];

                $e8= null;
                $phone=trim($_POST["phone"]);
                $phone=strip_tags($phone);
                $phone=htmlspecialchars($phone,ENT_QUOTES);
                $phone=stripslashes($phone);
                if(strlen($phone)==""){
                    $e8 .= "Заполните поле 'Телефон'<br>";
                } else if(!preg_match('/[+][375][0-9]{9}/', $phone)) {
                    $e8 .= "Неверный формат телефона (+375xxxxxxxxx)<br>";
                }
            
                $e9= null;
                $adress=trim($_POST["adress"]);
                $adress=strip_tags($adress);
                $adress=htmlspecialchars($adress,ENT_QUOTES);
                $adress=stripslashes($adress);
                if(strlen($adress)==""){
                    $e9.= "Заполните поле 'Адрес доставки'<br>";
                } else if(!preg_match('/[г.][А-Яа-я] [ул.][А-Яа-я] [д.][А-Я0-9]/', $adress)){
                    $e9.= "Неправильный формат адреса (г.ХХХ ул.ХХХ д.ХХ)<br>";
                }
            
                $id = $_GET['count'];
                $e = $e8.$e9;
            
                if($e == ""){
                    include("../connect/connect.php");
                    foreach($_SESSION['id_order_product'] as $item) {
                        $query_insert = " INSERT INTO orders (login, id_product, phone, adress)  VALUES ('$login','$item','$phone', '$adress')";
                        $result_insert=mysqli_query($link, $query_insert) or die("Ошибка " . mysqli_error($link));
            
                        if($id == 'all') {
                            $query_delete = "DELETE FROM `basket` WHERE `login`='$login'";
                        } else {
                            $query_delete = "DELETE FROM `basket` WHERE `id`='$id' AND `login`='$login'";
                        }
                        
                        $result_delete = mysqli_query($link, $query_delete) or die("Ошибка " . mysqli_error($link));
            
                        print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location ='../basket.php'};
                        setTimeout('reload()', 0);
                        </script>";
                    }
                } 
            } 
        ?>
        <div class="registration__screen">
            <div class="order__image">
                <div>
                <?php
                
                include("../connect/connect.php");
                $login = $_SESSION['login'];
                $query = "SELECT * FROM `users` WHERE `login` = '$login'";
                $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                $row = mysqli_fetch_row($result);
                $surname = $row[1]; $name = $row[2]; $phone = $row[3]; $array = array();

                if($_GET['count']=='all'){
                    $query_prod = "SELECT * FROM `basket` INNER JOIN `product` ON `product_id` = `id_product` WHERE `login`= '$login' AND `status`= 0";
                    $res = mysqli_query($link, $query_prod) or die("Ошибка " . mysqli_error($link));
                    if($res) {
                        $rows = mysqli_num_rows($res); // количество полученныхстрок
                        for ($i = 0 ; $i < $rows ; ++$i)
                        {
                            $row = mysqli_fetch_row($res);
                            $array[$i] = $row[1];
                            $title = $row[6];
                            $img = $row[7];
                            $price = $row[8];
                        
                            echo "<div class=\"product__item1\">
                            <img src=\"../$img\" class=\"product__img1\">
                            <div><p class='basket__text'>$title</p><p class='basket__text'>$price BYN</p></div>
                            
                            </div>";

                            $sum += $price; 
                        }
                    }
                    $count_id  = $_GET['count'];
                }
                else {
                    $product = $_GET['count'];
                    $query_prod = "SELECT * FROM `basket` INNER JOIN `product` ON `product_id` = `id_product` WHERE `login`= '$login' AND `id`='$product' AND `status`= 0";
                    $res = mysqli_query($link, $query_prod) or die("Ошибка " . mysqli_error($link));
                    if($res) {
                        $rows = mysqli_num_rows($res); // количество полученныхстрок
                        for ($i = 0 ; $i < $rows ; ++$i)
                        {
                            $row = mysqli_fetch_row($res);
                            $array[$i] = $row[1];
                            $title = $row[6];
                            $img = $row[7];
                            $price = $row[8];
                        
                            echo "<div class=\"product__item1\">
                            <img src=\"../$img\" class=\"product__img1\">
                            <div><p class='basket__text'>$title</p><p class='basket__text'>$price BYN</p></div>
                            </div>";

                            $sum += $price; 
                        }
                    }
                    $count_id  = $_GET['count'];
                }
                $_SESSION['id_order_product'] = $array;
                ?>
                </div>
                <p class="title1">Итого: <?php echo $sum?> BYN</p>
            </div>
            <div class="reg__constraction">
                <h2>Оформить заказ</h2>
                <form action='orders_form.php?count=<?=@$count_id;?>' method="post">
                <p class="label"> 
                <label>Фамилия:</label>
                <input name="surname" value="<?=@$surname;?>" type="text" size="25" maxlength="25"  disabled>
                </p> 

                <p class="label">
                <label>Имя:</label>
                <input name="first_name" value="<?=@$name;?>" type="text" size="25" maxlength="25"  disabled>
                </p>                 

                <p class="label">
                <label>Номер телефона:</label>
                <input name="phone" type="text" value="<?=@$phone;?>" size="25" maxlength="25">
                </p>                 <span class="error"><?=@$e8;?></span>

                <p class="label">
                <label>Адрес доставки:</label>
                <input type="text" name="adress" value="<?=@$adress;?>" size="25" maxlength="25" autofocus>
                </p>                 <span class="error"><?=@$e9;?></span>

                <p style="margin-left: 25%; margin-top: 50px;">
                <input type="submit" class="button__reg" name="submit" value="Заказать" >
                </p>
                </form>

                <p class="label">
                    <a href="../index.php">Главная страница</a>
                </p>
            </div>
        </div>
    </body>
</html>

