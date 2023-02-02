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
if(strlen($password)==""):
    $e2.="Заполните поле 'Пароль'<br>";
endif;
/* if (!preg_match('/[%?^#$_]?[A-Za-z_0-9]{6,}/', $password)){
    $e2.="Пароль не соответсвует шаблону; [%?^#\$_]?[A-Za-z_0-9]{6,} <br>";
    myError(strip_tags($e2));
} */

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
/* if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $e4 .= "Неверный e-mail<br>";
    myError(strip_tags($e4));
}
if (preg_match("/(\@bk)/i", $email)){
   $e4.="Емайл содержит запрещённые слова <br>";
    myError(strip_tags($e4));
} */

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
?>