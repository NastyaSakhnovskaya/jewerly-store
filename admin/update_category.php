<?php
    echo "<link rel='stylesheet' href='../css/admin.css'>";
    include "../connect/connect.php";

    if($_GET['id']) {
        $id = $_GET['id'];
        $query="SELECT * FROM `category` WHERE `id_category`='$id'";
        $res=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($res>0) {
            $count = mysqli_num_rows($res);
            for($i = 0 ; $i <$count ; ++$i) {
                $row = mysqli_fetch_row($res);
                $id = $row[0];
                $title = $row[1];
                $image = $row[2];
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
                        <li><a href="admin.php?parametr=товары" class = "admin_li">Товары</a></li>
                        <li><a href="admin.php?parametr=заказы" class = "admin_li">Заказы</a></li>
                        <li><a href="admin.php?parametr=пользователи" class = "admin_li">Пользователи</a></li>
                    </ul>
                </div>
            <div style="display: flex; justify-content: space-between; margin-top:20px;">
                
                <div class="admin_content">
                    <form action="" method="POST">
                        <table class="tbl-30">
                            <tr>
                                <td>Название</td>
                                <td>
                                    <input type="text" name="title" placeholder="" value='<?php echo $title?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>Картинка</td>
                                <td>
                                    <img class='image_table' src='../<?php echo $image?>'>
                                </td>
                            </tr>
                            <tr>
                                <td>Новая картинка</td>
                                <td>
                                    <input type="file" name="image">
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
                            $title = $_POST['title'];
                            $id = $_GET['id'];
                            $image = "img/".$_POST['image'];

                            $query = "UPDATE `category` SET name ='$title', image = '$image' WHERE id_category = '$id'";
                            $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                            print "<script language='Javascript' type='text/javascript'>
                            function reload(){top.location ='admin.php'};
                            setTimeout('reload()', 0);
                            </script>";
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</section>