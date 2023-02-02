<?php
    echo "<link rel='stylesheet' href='../css/admin.css'>";
    include "../connect/connect.php";

    if($_GET['id']) {
        $id = $_GET['id'];
        $query="SELECT * FROM `product` WHERE `id_product`='$id'";
        $res=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($res>0) {
            $count = mysqli_num_rows($res);
            for($i = 0 ; $i <$count ; ++$i) {
                $row = mysqli_fetch_row($res);
                $id = $row[0];
                $id_category = $row[1];
                $title = $row[2];
                $image_ = $row[3];
                $price = $row[4];
                $metal = $row[5];
                $stone = $row[6];
                $result_ = mysqli_fetch_row(mysqli_query($link, "SELECT name FROM `category` WHERE id_category = '$id_category'"))[0];
            }
        }


    }
?>


<section class="admin">
    <div class="container">
        <div class="wrapper">
        <div class="menu_admin">
                    <ul>
                        <li><a href="admin.php?parametr=категории" class = "admin_li">Категории</a></li>
                        <li><a href="admin_product.php?parametr=товары" class = "admin_li">Товары</a></li>
                        <li><a href="admin.php?parametr=заказы" class = "admin_li">Заказы</a></li>
                        <li><a href="admin.php?parametr=пользователи" class = "admin_li">Пользователи</a></li>
                    </ul>
                </div>
            <div style="display: flex; justify-content: space-between; margin-top:20px;">
                
                <div class="admin_content">
                    <form action="" method="POST">
                        <table class="tbl-30">
                            <tr>
                                <td>ID товара</td>
                                <td>
                                    <input type="text" name="id"  value='<?php echo $id?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>Категория</td>
                                <td>
                                    <select name="category">
                                        <?php
                                            $query ="SELECT * FROM `category`";
                                            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                                            if($result) {
                                                $rows = mysqli_num_rows($result); // количество полученныхстрок
                                                for ($i = 1 ; $i <($rows+1) ; ++$i)
                                                {
                                                    $row = mysqli_fetch_row($result);
                                                    if($row[1] == $result_) {
                                                        echo "<option value='$row[0]' selected>$row[1]</option>";
                                                    } else {
                                                        echo "<option value='$row[0]'>$row[1]</option>";
                                                    } 
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Название</td>
                                <td>
                                    <input type="text" name="title"  value='<?php echo $title?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>Картинка</td>
                                <td>
                                    <img class='image_table' src='../<?php echo $image_?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>Новая картинка</td>
                                <td>
                                    <input type="file" name="image">
                                </td>
                            </tr>
                            <tr>
                                <td>Цена</td>
                                <td>
                                    <input type="text" name="price"  value='<?php echo $price?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>Металл</td>
                                <td>
                                    <input type="text" name="metal"  value='<?php echo $metal?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>Камень</td>
                                <td>
                                    <input type="text" name="stone"  value='<?php echo $stone?>'>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" name="submit" value="Сохранить" class="btn-secondary">
                                </td>
                            </tr>
                    </form>

                    <?php
                        if(isset($_POST['submit'])) {
                            $id = $_POST['id'];
                            $category = $_POST['category'];
                            $title = $_POST['title'];
                            if($_POST['image'] == null) {
                                $image = $image_; 
                            } else {
                                $image = "img/".$_POST['image'];
                            }
                            
                            $price = $_POST['price'];
                            $metal = $_POST['metal'];
                            $stone = $_POST['stone'];

                            $query = "UPDATE `product` SET id_product ='$id', id_category ='$category', name ='$title', image = '$image', price ='$price', metal ='$metal', stone ='$stone' WHERE id_product = '$id'";
                            $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                            print "<script language='Javascript' type='text/javascript'>
                            function reload(){top.location ='admin_product.php'};
                            setTimeout('reload()', 0);
                            </script>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>