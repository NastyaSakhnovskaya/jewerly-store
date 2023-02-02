<?php
    include "connect/connect.php";
    $date = date("Y-m-d H:i:s");
    $login = $_POST['username'];
    $comment = $_POST['message'];
    $sql = "INSERT INTO `reviews` (login, comment, date) VALUES ('$login', '$comment', '$date')";
    $result = mysqli_query($link, $sql);
    if($result) {
       $sql_review = "SELECT * FROM `reviews` ORDER BY `date` DESC LIMIT 3";
                       $result_reviews = mysqli_query($link, $sql_review);
                       if($result_reviews) {
                           $rows = mysqli_num_rows($result_reviews); // количество полученныхстрок
                           for ($i = 0 ; $i < $rows ; ++$i)
                           {
                               $row = mysqli_fetch_row($result_reviews);
                               $date = $row[3];
                               $login = $row[1];
                               $comment = $row[2];
                               echo "<div class='com_block'><p class='text_user'>".$login."</p><p class='text_date'>".$date."</p><p class='text_com'>".$comment."</p></div>";
                           }
                       }
    }
    else {
        echo "error";
    }
   
    
?>