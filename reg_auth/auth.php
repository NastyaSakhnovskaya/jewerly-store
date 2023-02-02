
<html>
    <head>
        <title>Jewerly store</title>
        <link rel='stylesheet' href='../css/reg.css'>
    </head>
    <body>
        <div class="registration__screen">
            <div class="reg__image"></div>
            <div class="reg__constraction">
                <h2>Авторизация</h2>
                <form action="auth_in.php" method="post">

                <p class="label">
                <label>Ваш логин:</label>
                <input type="text" name="login" value="<?=@$login;?>" size="25" maxlength="25" autofocus>
                </p>                <span class="error"><?=@$e1;?></span>

                <p class="label">
                <label>Ваш пароль:</label>
                <input name="password" type="password" size="25" maxlength="25">
                </p>

                <p class="label">
                <label>Подтверждение пароля:</label>
                <input name="password2" type="password" size="25" maxlength="25">
                </p>

                <p style="margin-left: 25%; margin-top: 50px;">
                <input type="submit" class="button__reg" name="submit" value="Войти" >
                </p>
                </form>

                <p class="label">
                    <a href="../index.php">Главная страница</a>
                    <a href="reg.php">Создать аккаунт</a>
                </p>
            </div>
        </div>
    </body>
</html>

