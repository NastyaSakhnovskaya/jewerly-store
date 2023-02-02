<?php
    echo "<link rel='stylesheet' href='../css/admin.css'>";
    include "../connect/connect.php";
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
                    <table class="tbl-full">
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Товар</th>
                            <th>Телефон</th>
                            <th>Адрес</th>
                            <th>Статус</th>
                            <th>Изменить статус</th>
                        </tr>
                        
                        <?php
                            $sql = "SELECT * FROM `orders`";
                            $res = mysqli_query($link, $sql)or die("Ошибка " . mysqli_error($link));
                            if($res>0) {
                                $count = mysqli_num_rows($res);
                                for($i = 0 ; $i <$count ; ++$i) {
                                    $row = mysqli_fetch_row($res);
                                    $id = $row[0];
                                    $id_product = $row[2];
                                    $login = $row[1];
                                    $phone = $row[3];
                                    $adres = $row[4];
                                    $status = $row[5];
                                    $result = mysqli_fetch_row(mysqli_query($link, "SELECT name FROM `product` WHERE id_product = '$id_product'"))[0];

                                    echo "<tr>";
                                    echo "<td>$id</td>";
                                    echo "<td>$login</td>";
                                    echo "<td>$result</td>";
                                    echo "<td>$phone</td>";
                                    echo "<td>$adres</td>";
                                    echo "<td>$status</td>";

                                    echo "<td><form action='update_status.php?id=$id_product&login=$login' method='POST'>
                                    <select name='status'>
                                    <option value='на складе'>на складе</option>
                                    <option value='в пути'>в пути</option>
                                    <option value='доставлен'>доставлен</option>
                                    </select>
                                    <input type='submit' name='submit' value='Изменить'>
                                    </form>
                                    </td>";
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
