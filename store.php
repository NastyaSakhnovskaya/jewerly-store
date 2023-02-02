<?php
include "header.php";
?>

<section class="find">
    <div class="container">
        <div class="wrapper">
            <div class="filters__block">
                <?php
                    include "connect/connect.php";
                    if(isset($_GET['category_id'])){
                        $table = 'category';
                        $category_id=$_GET['category_id'];
                        $sql = "SELECT name FROM $table WHERE id_category = $category_id";
                        $res = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
                        $row = mysqli_fetch_row($res);
                    }
                ?>
                
                <div class="filters"> 
                    <div class = "all_product"><a href='store.php?category_id=0'>Все товары</a></div>
                    <div class="block__title">Категории</div>
                    <div class="filter__text">
                        <?php
                            $_SESSION['filters']='category';//Боковая панель фильтров
                            include 'connect/connect.php'; //подключаемся к БД
                            if ($_SESSION['menu']=='category') $table='category';
                            $query ="SELECT name FROM $table";
                            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                            if($result) {
                                $rows = mysqli_num_rows($result); // количество полученныхстрок
                                for ($i = 1 ; $i <($rows+1) ; ++$i) {
                                    $row = mysqli_fetch_row($result);
                                    if ($_SESSION['menu']=='category') echo "<p class=\"nav__link1\"><a href='store.php?category_id=$i'>$row[0]</a></p>";
                                }
                            }
                            mysqli_close($link);
                        ?>
                    </div>
                    <form action="#" method="POST">
                        <div class="block__title">Металл</div>
                        <div class="filter__text">
                            <input type="radio" name="metal" class="nav__link1" value="золото">Золото<br>
                            <input type="radio" name="metal" class="nav__link1" value="белое золото">Белое золото<br>
                            <input type="radio" name="metal" class="nav__link1" value="серебро">Серебро
                        </div>       
                        <div class="block__title">Камень</div>
                        <div class="filter__text">
                            <input type="radio" name="stone" class="nav__link1" value="бриллиант">Бриллиант<br>
                            <input type="radio" name="stone" class="nav__link1" value="аметист">Аметист<br>
                            <input type="radio" name="stone" class="nav__link1" value="фианит">Фианит
                        </div>
                        <div class="block__title">Цена</div>
                        <div class="filter__text">
                            <input type="radio" name="price" class="nav__link1" value="10 AND 99">10-99<br>
                            <input type="radio" name="price" class="nav__link1" value="100 AND 499">100-499<br>
                            <input type="radio" name="price" class="nav__link1" value="500 AND 999">500-999<br>
                            <input type="radio" name="price" class="nav__link1" value="1000 AND 100000">1000-...
                        </div>
                        <input type='submit' value='OK' id="search_btn" class="search-btn">
                    </form>
                </div>
                

                <div class="filter__result">
                <?php
                function str_replace_once($search, $replace, $text) //фильтрация
                { 
                   $pos = strpos($text, $search); 
                   return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text; 
                } 
                    if(isset($_POST["metal"])) {
                        $func1 = $_POST["metal"]." / ";
                        $filter1 = " AND metal = \"".$_POST["metal"]."\"";
                    }
                    if(isset($_POST["stone"])) {
                        $func2 = $_POST["stone"]." / ";
                        $filter2 = " AND stone = \"".$_POST["stone"]."\"";
                    } 
                    if(isset($_POST["price"])){
                        $func3 = $_POST["price"]." / ";
                        $filter3 = " AND price BETWEEN ".$_POST["price"];
                    } 

                    $_SESSION['finder']= $func1.$func2.$func3; 
                    $select_all = $filter1.$filter2.$filter3;
                    $_SESSION['select_finder']= $filter1.$filter2.$filter3; 

                    include "connect/connect.php";
                    if(isset($_GET['category_id'])){
                        if($_GET['category_id']!=0) {
                            $table = 'category';
                            $category_id=$_GET['category_id'];
                            $sql = "SELECT name FROM $table WHERE id_category = $category_id";
                            $res = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));
                            $row = mysqli_fetch_row($res);
                            ?>

                            <h2><?php echo $row[0];?></h2><p class="nav__link1"><?php echo $_SESSION['finder'];?></p>
                            <?php
                        }
                        else {
                            ?>
                            <h2>Все товары</h2>
                            <?php
                        }
                    }
                    if(isset($_POST['search'])) {
                        $search_result = $_POST['search'];
                        echo "<h2>$search_result</h2>";
                    }
                    ?>                                           
                    <div class="product__items">
                    <?php
                        $_SESSION['product__item']='product__cards'; //результаты фильтрации
                        include 'connect/connect.php'; //подключаемся к БД
                        if ($_SESSION['product__item']=='product__cards') $table='product';
                        if($_GET['category_id']!=0){
                           
                            $query_name ="SELECT * FROM $table WHERE id_category = $category_id".$_SESSION['select_finder'];
                        }
                        else {
                            if($select_all==null){
                                $query_name ="SELECT * FROM $table";
                            } else {
                                $_SESSION['select_finder'] = str_replace_once("AND", '', $select_all);
                                $query_name ="SELECT * FROM $table WHERE".$_SESSION['select_finder'];
                            } 
                        }
                        if(isset($_POST['search'])) { //запрос поиска
                            $search_result = $_POST['search']; 
                            $query_name = "SELECT * FROM product WHERE name LIKE '%$search_result%' or metal LIKE '%$search_result%' or stone LIKE '%$search_result%'";
                           
                        }
                        $result_name = mysqli_query($link, $query_name) or die("Ошибка " . mysqli_error($link));
                        if($result_name) {
                            $rows = mysqli_num_rows($result_name); // количество полученныхстрок
                            for ($i = 1 ; $i < ($rows+1) ; ++$i)
                            {
                                $row = mysqli_fetch_row($result_name);
                                $product_id = $row[0];
                                $title = $row[2];
                                $img = $row[3];
                                $price = $row[4];
                                $metal = $row[5];
                                $stone = $row[6];
                                echo "<div class=\"product__item\"><img src=\"$img\" class=\"product__img\"><p>$title</p><p>$price BYN</p><p>$metal</p><p>$stone</p>
                                <a href='acc/updata.php?product_id=$product_id' class='btn'>Корзина</a></div>";
                            }
                        }
                        mysqli_close($link);
                    ?>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include "footer.php";
?>
