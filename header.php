<?php
    //Запускаем сессию
    session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Jewerly store</title>
        <link rel="stylesheet" href="../css/menu.css">
        <link rel="stylesheet" href="../css/body.css">
        <script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
    </head>
    <body>
        <header class="header" id="header">
            <div class="container">
                <div class="wrapper">
                    <a href="../index.php"><img src="img/pngwing.com.png" class="logo"></a>
                    <nav class="nav">
                        <ul class="nav__list">
                            <li class="nav__item" id="category"><a class="nav__link" href="">Категории</a>
                                <ul class="submenu">
                                    <?php
                                    $_SESSION['menu']='category';
                                    include 'menu.php';
                                    ?>
                                </ul>
                            </li>
                            <?php 
                            if (!empty($_SESSION['login'])) {
                                $log = $_SESSION['login'];
                                include("connect/connect.php");
                                $query="SELECT * FROM users WHERE login='$log'";
                                $rez = mysqli_query($link, $query);
                                $row = mysqli_fetch_assoc($rez);
                                
                            ?>
                            <li class="nav__item" id="acc"><a class="nav__link" href=""><?=@$log?></a>
                                <ul class="submenu">
                                       <li><a href="basket.php">Корзина</a></li>
                                       <li><a href="reg_auth/auth_out.php">Выйти</a></li>
                                </ul>
                            </li>
                            <?php
                           } 
                           else {
                               ?>
                               <li class="nav__item" id="acc"><a class="nav__link" href="">Мой аккаунт</a>
                                <ul class="submenu">
                                       <li><a href="reg_auth/reg.php">Регистрация</a></li>
                                       <li><a href="reg_auth/auth.php">Войти</a></li>
                                </ul>
                            </li>
                               <?
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main>
        <section id="main__screen" class="main__screen">
                <div class="container">
                    <div class="wrapper">
                        <div class="header-search">
                            <form action="store.php" method="POST">
                                <input name='search' class="input" id="search" type="search" placeholder="Я ищу...">
								<input type="submit" id="search_btn" class="search-btn" value = "Поиск">
                            </form>
                        </div>
                    </div>
                </div>
        </section>
   
