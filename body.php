<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<section class="suggestion">
    <div class="container">
        <div class="wrapper">
            <h2>Мы предлагаем</h2>
            <div class="category__cards">
                <?php
                    $_SESSION['category__item']='category__cards';
                    include 'connect/connect.php'; //подключаемся к БД
                    //Выборка данных из БД в соответствии с запросом и вывод их во фрейм
                    if ($_SESSION['category__item']='category__cards') $table='category';
                    
                    $query_name ="SELECT name FROM $table"; 
                    $query_img ="SELECT image FROM $table";
                    $result_name = mysqli_query($link, $query_name) or die("Ошибка " . mysqli_error($link));
                    $result_img = mysqli_query($link, $query_img) or die("Ошибка " . mysqli_error($link));
                    if($result_name) {
                        $rows = mysqli_num_rows($result_name); // количество полученныхстрок
                        for ($i = 1 ; $i < ($rows+1) ; ++$i)
                        {
                            $row_name = mysqli_fetch_row($result_name);
                            $row_img = mysqli_fetch_row($result_img);
                            if ($_SESSION['category__item']='category__cards') 
                                echo "<a href='store.php?category_id=$i'><div class=\"category__item\"><img src=\"{$row_img[0]}\" class=\"cat__img\"><p class='text_date1'>$row_name[0]</p></div></a>";
                        }
                    }
                    mysqli_close($link);
                ?>     
            </div>
        </div>
    </div>
</section>

<section class="new__product">
    <div class="container">
        <div class="wrapper">
            <h2>Новинки</h2>
            <div class="product__cards">
                <?php
                include "connect/connect.php";
                $table="product";
                $query="SELECT * FROM $table";
                $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                if($result) {
                    $rows = mysqli_num_rows($result); // количество полученныхстрок
                    for ($i = 1 ; $i < 4 ; ++$i)
                    {
                        $row = mysqli_fetch_row($result);
                        $product_id =  $row[0];
                        $title = $row[2];
                        $img = $row[3];
                        $price = $row[4];
                        $metal = $row[5];
                        $stone = $row[6];
                        echo "<div class=\"new__item\"><div class=\"image__item\"><img src=\"$img\" class=\"product__image\"></div>
                        <div class=\"info__item\">
                        <ul class=\"product__list\">
                        <li class=\"main__text\">$title</li>
                        <li class=\"main__text\">Цена: $price BYN</li>
                        <li class=\"main__text\">Металл: $metal</li>
                        <li class=\"main__text\">Камень: $stone</li>
                        </ul>
                        <a class=\"basket main__text\" href='acc/updata.php?product_id=$product_id'>Корзина</a>
                        </div></div>";
                    }
                }
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</section>



<section class="reviews">
    <div class="container">
        <div class="wrapper">
            <h2>Отзывы</h2>
            <div class="review_block">
                <div class="review_text" id="review_text">
                    <?php
                        include "connect/connect.php";
                        $sql_review = "SELECT * FROM `reviews` ORDER BY `date` DESC LIMIT 3";
                        $result_reviews = mysqli_query($link, $sql_review);
                        if($result_reviews ) {
                            $rows = mysqli_num_rows($result_reviews); // количество полученныхстрок
                            for ($i = 0 ; $i < $rows ; ++$i)
                            {
                                $row = mysqli_fetch_row($result_reviews);
                                $date = $row[3];
                                $login = $row[1];
                                $comment = $row[2];
                                echo "<div class='com_block'><p class='text_user'>$login</p><p class='text_date'>$date</p><p class='text_com'>$comment</p></div>";
                            }
                        }
                    ?>
                </div>
                <div class="review_form">
                    <form class="form" id="ajax_form">
                    <p style="font-size:24px; font-weight: 500">Оставить отзыв</p>
                        <label style="margin:10px 0;">Логин</label>
                        <input type="text" name="username" class="review_user" value="<?=@$_SESSION['login'];?>" id="username">
                        <label style="margin:10px 0;">Комментарий</label>
                        <textarea name="message" class="comment" id="message"></textarea>
                        <input type="submit" class="review_button"  value="Отправить">
                    </form>

                    <script>  
                        $(document).ready(function(){  
                        
                            $('#ajax_form').submit(function(){  
                                $.ajax({  
                                    type: "POST",  
                                    url: "add_review.php",  
                                    data: $('#ajax_form').serialize(), 
                                    success: function(html){  
                                        $("#review_text").html(html);
                                        $("#message").val(" "); 
                                    }  
                                });  
                                return false;  
                            });  
                            
                        });  
                    </script>  
                </div>
            </div>
        </div>
    </div>
</section>

