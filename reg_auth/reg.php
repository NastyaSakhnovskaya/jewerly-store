
<html>
    <head>
        <title>Jewerly store</title>
        <link rel='stylesheet' href='../css/reg.css'>
    </head>
    <body>
    <?php
        if(session_status()!=PHP_SESSION_ACTIVE) session_start();

        if (isset($_POST['login'])) { 
            $login = $_POST['login'];
            if ($login =='') { unset($login);} 
        } //заносим введенный пользователем логин впеременную $login, если он пустой, то уничтожаем переменную
        if (isset($_POST['password'])) { 
            $password=$_POST['password'];
            if($password =='') { unset($password);} 
        }//заносим введенный пользователем пароль в переменную $password, если он пустой, то уничтожаем переменную
        if (isset($_POST['password2'])) { 
            $password2=$_POST['password2'];
            if($password2 =='') { unset($password2);} 
        }
        if (isset($_POST['email'])) { 
            $email=$_POST['email'];
        if ($email =='') { unset($email);} 
        }
            
        if (isset($_POST['surname'])) { 
            $surname = $_POST['surname'];
            if($surname == '') { unset($surname);} 
        }
        if (isset($_POST['first_name'])) { 
            $first_name = $_POST['first_name'];
            if ($first_name == '') { unset($first_name);} 
        }

        if (isset($_POST['phone'])) { 
            $phone = $_POST['phone'];
            if ($phone == '') { unset($phone);} 
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['submit'])) {
            $e1=null;
            $login=trim($_POST["login"]);
            $login=strip_tags($login);
            $login=stripslashes($login);
            if(strlen($login)==""):
                $e1.="Заполните поле 'Ваш логин'<br>";
            endif;
            /* if(preg_match('/([a-zA-ZА-ЯЁа-яё0-9_])\\1{4,}/u', $login) || preg_match('/(([a-zA-ZА-ЯЁа-яё0-9_]){,3})/' ,$login)) { 
                $e1.="Введеный логин не соответствует требованиям<br>";
                myError(strip_tags($e1));
            } */
            include("../connect/connect.php"); //подключаемся к БД
            $query="SELECT login FROM users WHERE login='$login'";
            $result = mysqli_query($link, $query) or die("Ошибка выполнения запроса" . mysqli_error($link));
            if ($result){
                $row = mysqli_fetch_row($result);
                if (!empty($row[0])) $e1.="Данный логин занят"; // проверка на существование в БД такого же логина
            }

            $e2=null;
            $password=trim($_POST["password"]);
            $password=strip_tags($password);
            $password=htmlspecialchars($password,ENT_QUOTES);
            $password=stripslashes($password);
            if(strlen($password)==""){
                $e2.="Заполните поле 'Пароль'<br>";
            } else if(!preg_match('/[A-Za-z_0-9$%&*@#]{6,}/', $password)){
                $e2.="Пароль должен состоять из 6+ символов, может начинаться с $,%,&,*,@,#,_<br>";
            }

            $e3=null;
            $password2=trim($_POST["password2"]);
            $password2=strip_tags($password2);
            $password2=htmlspecialchars($password2,ENT_QUOTES);
            $password2=stripslashes($password2);
            if(strlen($password2)=="") {
                $e3 .= "Заполните поле 'Подтверждение пароля'<br>";
            }
            if ($password!=$password2):
                $e2.="Пароли не совпадают<br>";
            endif;

            $e4=null;
            $email=trim($_POST["email"]);
            $email=strip_tags($email);
            $email=htmlspecialchars($email,ENT_QUOTES);
            $email=stripslashes($email);
            if(strlen($email)==""){
                $e4 .= "Заполните поле 'Email'<br>";
            } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $e4 .= "Неверный e-mail<br>";
            }

            $e5=null;
            $surname=trim($_POST["surname"]);
            $surname=strip_tags($surname);
            $surname=htmlspecialchars($surname,ENT_QUOTES);
            $surname=stripslashes($surname);
            if(strlen($surname)==""){
                $e5 .= "Заполните поле 'Фамилия'<br>";
            } else if(!preg_match('/[А-Яа-яA-za-z]/', $surname)) {
                $e5 .= "Должна содержать только буквы<br>";
            }

            $e6=null;
            $first_name=trim($_POST["first_name"]);
            $first_name=strip_tags($first_name);
            $first_name=htmlspecialchars($first_name,ENT_QUOTES);
            $first_name=stripslashes($first_name);
            if(strlen($first_name)==""){
                $e6 .= "Заполните поле 'Имя'<br>";
            } else if(!preg_match('/[А-Яа-яA-za-z]/', $first_name)) {
                $e6 .= "Должно содержать только буквы<br>";
            }

            $e8=null;
            $phone=trim($_POST["phone"]);
            $phone=strip_tags($phone);
            $phone=htmlspecialchars($phone,ENT_QUOTES);
            $phone=stripslashes($phone);
            if(strlen($phone)==""){
                $e8 .= "Заполните поле 'Телефон'<br>";
            } else if(!preg_match('/[+][375][0-9]{9}/', $phone)) {
                $e8 .= "Неверный формат телефона (+375xxxxxxxxx)<br>";
            }
            

            $eEn=$e1.$e2.$e3.$e4;
            if($eEn==""){
                $password =md5($password);
                $query="INSERT INTO users (login, surname, name, phone, email, password)  VALUES ('$login','$surname','$first_name', '$phone','$email','$password')";
                $result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                if ($result) //пишем данные в БД и авторизовываем пользователя
                {
                    $query="SELECT * FROM users WHERE login='$login'";
                    $rez = mysqli_query($link, $query);
                    if ($rez)
                    {
                        $row = mysqli_fetch_assoc($rez);

                        $_SESSION['login'] = $row['login'];
                        $_SESSION['surname']=$row['surname'];
                        //$_SESSION['first_name']=$row['first_name'];
                        //$_SESSION['second_name']=$row['second_name'];

                        mysqli_close($link);
                        // выводим уведомление об успехе операции и перезагружаем страничку
                        print "<script language='Javascript' type='text/javascript'>
                        function reload(){top.location ='../index.php'};
                        setTimeout('reload()', 0);
                        </script>";
                    }
                    else
                    {
                        print "<script language='Javascript' type='text/javascript'>
                        alert ('Ваши данные не были снесены в БД!');
                        </script>";
                    }
                }
            }
        }
        
        ?>
        <div class="registration__screen">
            <div class="reg__image"></div>
            <div class="reg__constraction">
                <h2>Регистрация</h2>
                <form action="reg.php" method="post">
                <p class="label"> 
                <label>Фамилия:</label>
                <input name="surname" value="<?=@$surname;?>" type="text" size="25" maxlength="25">
                </p> <span class="error"><?=@$e5;?></span>

                <p class="label">
                <label>Имя:</label>
                <input name="first_name" value="<?=@$first_name;?>" type="text" size="25" maxlength="25">
                </p>                 <span class="error"><?=@$e6;?></span>

                <p class="label">
                <label>Номер телефона:</label>
                <input name="phone" type="text" value="<?=@$phone;?>" size="25" maxlength="25">
                </p>                 <span class="error"><?=@$e8;?></span>

                <p class="label">
                <label>Ваш логин:</label>
                <input type="text" name="login" value="<?=@$login;?>" size="25" maxlength="25" autofocus>
                </p>                <span class="error"><?=@$e1;?></span>

                <p class="label">
                <label>Email:</label>
                <input name="email" value="<?=@$email;?>" type="text" size="25" maxlength="25">
                </p>                 <span class="error"><?=@$e4;?></span>

                <p class="label">
                <label>Ваш пароль:</label>
                <input name="password" type="password" size="25" maxlength="25">
                </p>                 <span class="error"><?=@$e2;?></span>

                <p class="label">
                <label>Подтверждение пароля:</label>
                <input name="password2" type="password" size="25" maxlength="25">
                </p>                <span class="error"><?=@$e3;?></span>

                <p style="margin-left: 25%; margin-top: 50px;">
                <input type="submit" class="button__reg" name="submit" value="Зарегистрироваться" >
                </p>
                </form>

                <p class="label">
                    <a href="../index.php">Главная страница</a>
                    <a href="auth.php">Уже есть аккаунт</a>
                </p>
            </div>
        </div>
    </body>
</html>

