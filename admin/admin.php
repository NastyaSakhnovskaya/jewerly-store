<?php
    echo "<link rel='stylesheet' href='../css/admin.css'>";
    include "../connect/connect.php";
?>
 <?php 
    if(isset($_POST['submit'])) {

        $title = $_POST['title'];
        $image = "img/".$_POST['image'];

        $query="INSERT INTO category (name, image)  VALUES ('$title','$image')";
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
                                <td>Название</td>
                                <td>
                                    <input type="text" name="title" placeholder="Категория">
                                </td>
                            </tr>
                            <tr>
                                <td>Картинка</td>
                                <td>
                                    <input type="file" name="image">
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
                            <th>Название</th>
                            <th>Картинка</th>
                            <th>Действия</th>
                        </tr>
                        
                        <?php
                            $sql = "SELECT * FROM `category`";
                            $res = mysqli_query($link, $sql)or die("Ошибка " . mysqli_error($link));
                            if($res>0) {
                                $count = mysqli_num_rows($res);
                                for($i = 0 ; $i <$count ; ++$i) {
                                    $row = mysqli_fetch_row($res);
                                    $id = $row[0];
                                    $title = $row[1];
                                    $image = $row[2];
                                    echo "<tr>";
                                    echo "<td>$id</td>";
                                    echo "<td>$title</td>";
                                    echo "<td><img class='image_table' src='../$image'></td>";

                                    echo "<td><a href='update_category.php?id=$id&name=category' class='btn secondary'>Обновить</a><a href='delete_category.php?id=$id&name=category' class='btn danger'>Удалить</a></td>";
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
