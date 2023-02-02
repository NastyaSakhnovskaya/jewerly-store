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
                            <th>Логин</th>
                            <th>Фамилия</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Почта</th>
                        </tr>
                        
                        <?php
                            $sql = "SELECT * FROM `users`";
                            $res = mysqli_query($link, $sql)or die("Ошибка " . mysqli_error($link));
                            if($res>0) {
                                $count = mysqli_num_rows($res);
                                for($i = 0 ; $i <$count ; ++$i) {
                                    $row = mysqli_fetch_row($res);
                                    $login = $row[0];
                                    $surname = $row[1];
                                    $name = $row[2];
                                    $phone = $row[3];
                                    $email = $row[4];
                                    echo "<tr>";
                                    echo "<td>$login</td>";
                                    echo "<td>$surname</td>";
                                    echo "<td>$name</td>";
                                    echo "<td>$phone</td>";
                                    echo "<td>$email</td>";
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
