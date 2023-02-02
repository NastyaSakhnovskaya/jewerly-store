
<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if (isset($_POST['login'])) { $login = $_POST['login'];
if ($login== '') { unset($login);} }
if (isset($_POST['password'])) { $password=$_POST['password'];
if ($password =='') { unset($password);} }
if (isset($_POST['password2'])) { $password2=$_POST['password2'];
    if ($password2 =='') { unset($password2);} }
if (empty($login) or empty($password) or empty($password2))
{
    print "<script language='Javascript' type='text/javascript'>
    alert ('Вы заполнили не все поля!');
    function reload(){location = 'auth.php'};
    setTimeout('reload()', 0);
    </script>";
    exit();
}
$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
$password2 = stripslashes($password2);
$password2 = htmlspecialchars($password2);
$login = trim($login);
$password = trim($password);
$password2 = trim($password2);
include("../connect/connect.php");
$query ="SELECT * FROM users WHERE login='$login'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
$row = mysqli_fetch_assoc($result);
if (empty($row['login']))
{
    mysqli_close($link);
    print "<script language='Javascript' type='text/javascript'>
    alert ('Такого логина не существует!');
    function reload(){location = 'auth.php'};
    setTimeout('reload()', 0)
    </script>";
}
else {
    if ($row['password']===md5($password))
    {
        if ($password==$password2) {

            if($row['login'] == 'admin') {
                print "<script language='Javascript' type='text/javascript'>
                function reload(){top.location = '../admin/admin.php'};
                setTimeout('reload()', 0)
                </script>";
            } else {
                $_SESSION['login']=$row['login'];
                $_SESSION['surname']=$row['surname'];
                
                print "<script language='Javascript' type='text/javascript'>
                function reload(){top.location = '../index.php'};
                setTimeout('reload()', 0)
                </script>";
            }
        }
        else {
            print "<script language='Javascript' type='text/javascript'>
            alert ('Пароли не совпадают!');
            function reload(){location = 'auth.php'};
            setTimeout('reload()', 0)
            </script>";
        }
    }
    else {
        echo $password." ".$row['password'];
        print "<script language='Javascript' type='text/javascript'>
        alert ('Вы ввели не правильный пароль!');
        function reload(){location = 'auth.php'};
        setTimeout('reload()', 0)
        </script>";
    }
    mysqli_close($link);
}
?>