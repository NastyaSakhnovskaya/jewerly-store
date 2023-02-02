<?php
    echo "<link rel='stylesheet' href='../css/admin.css'>";
    include "../connect/connect.php";
?>
 <?php 
    if(isset($_POST['submit'])) {
        $id = $_POST['id'];
        $category = $_POST['category'];
        $title = $_POST['title'];
        $image = "img/".$_POST['image'];
        $price = $_POST['price'];
        $metal = $_POST['metal'];
        $stone = $_POST['stone'];

        $query="INSERT INTO product (id_product, id_category, name, image, price, metal, stone)  VALUES ('$id', '$category','$title','$image', '$price', '$metal', '$stone')";
        $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

    }
?>
<section class="admin">
    <div class="container">
        <div class="wrapper">
        <div class="menu_admin">
                    <ul>
                        <li><a href="admin.php?parametr=категории" class = "admin_li">Категории</a></li>
                        <li><a href="admin_product.php?parametr=товары" class = "admin_li">Товары</a></li>
                        <li><a href="admin_orders.php?parametr=заказы" class = "admin_li">Заказы</a></li>
                        <li><a href="admin_users.php?parametr=пользователи" class = "admin_li">Пользователи</a></li>
                        <li><a href="../index.php" class = "admin_li1">Выйти</a></li>
                    </ul>
                </div>
            <div style="display: flex; justify-content: space-between; margin-top:20px;">
                
                <div class="admin_content">
                    <form action="" method="POST">
                        <table class="tbl-30">
                            <tr>
                                <td>ID товара</td>
                                <td>
                                    <input type="text" name="id" placeholder="ID">
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
                                                    echo "<option value='$row[0]'>$row[1]</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Название</td>
                                <td>
                                    <input type="text" name="title" placeholder="Название">
                                </td>
                            </tr>
                            <tr>
                                <td>Картинка</td>
                                <td>
                                    <input type="file" name="image">
                                </td>
                            </tr>
                            <tr>
                                <td>Цена</td>
                                <td>
                                    <input type="text" name="price" placeholder="Цена">
                                </td>
                            </tr>
                            <tr>
                                <td>Металл</td>
                                <td>
                                    <input type="text" name="metal" placeholder="Металл">
                                </td>
                            </tr>
                            <tr>
                                <td>Камень</td>
                                <td>
                                    <input type="text" name="stone" placeholder="Камень">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" name="submit" value="Добавить" class="btn-secondary">
                                </td>
                            </tr>
                    </form>
                   
                    <table class="tbl-full">
                        <tr>
                            <th>ID</th>
                            <th>Категория</th>
                            <th>Название</th>
                            <th>Картинка</th>
                            <th>Цена</th>
                            <th>Металл</th>
                            <th>Камень</th>
                            <th>Действия</th>
                        </tr>
                        
                        <?php
                            $sql = "SELECT * FROM `product`";
                            $res = mysqli_query($link, $sql)or die("Ошибка " . mysqli_error($link));
                            if($res>0) {
                                $count = mysqli_num_rows($res);
                                for($i = 0 ; $i <$count ; ++$i) {
                                    $row = mysqli_fetch_row($res);
                                    $id = $row[0];
                                    $id_category = $row[1];
                                    $title = $row[2];
                                    $image = $row[3];
                                    $price = $row[4];
                                    $metal = $row[5];
                                    $stone = $row[6];
                                    $result = mysqli_fetch_row(mysqli_query($link, "SELECT name FROM `category` WHERE id_category = '$id_category'"))[0];

                                    echo "<tr>";
                                    echo "<td>$id</td>";
                                    echo "<td>$result</td>";
                                    echo "<td>$title</td>";
                                    echo "<td><img class='image_table' src='../$image'></td>";
                                    echo "<td>$price BYN</td>";
                                    echo "<td>$metal</td>";
                                    echo "<td>$stone</td>";

                                    echo "<td><a href='update_product.php?id=$id&name=category' class='btn secondary'>Обновить</a><a href='delete_category.php?id=$id&name=product' class='btn danger'>Удалить</a></td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
