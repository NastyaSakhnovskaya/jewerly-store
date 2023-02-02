<?php
    include 'connect/connect.php'; //подключаемся к БД
    //Выборка данных из БД в соответствии с запросом и вывод их во фрейм
    if ($_SESSION['menu']=='category') $table='category';
    
    $query ="SELECT name FROM $table";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    if($result) {
        $rows = mysqli_num_rows($result); // количество полученныхстрок
        for ($i = 1 ; $i <($rows+1) ; ++$i)
        {
            $row = mysqli_fetch_row($result);
            if ($_SESSION['menu']=='category') echo "<li class=\"nav__link1\"><a href='store.php?category_id=$i'>$row[0]</a></li>";
        }
    }
    mysqli_close($link);
?>