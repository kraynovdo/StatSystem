<?if (!$_SESSION['userID']) {?>
<form action="/?r=user/auth" method="POST">
    <a href="/?r=registration" class="login-regLink">Регистрация</a>
    <input class='main-auth_login' type="text" name="username" autocomplete="false" placeholder="E-mail"/>
    <input  class='main-auth_pass' type="password" name="password" autocomplete="false" placeholder="Пароль"/>
    <input class="main-btn main-auth_btn" type="submit" value="Вход"/>
    <a href="/?r=user/forget">Забыли пароль?</a>
</form>
<?} else {?>
    <a href="/?r=registration" class="login-regLink">Регистрация</a>
    <a href="/?r=admin&person=<?=$_SESSION['userPerson']?>">Панель пользователя</a>
    <a href="/?r=user/logout">Выход</a>
<?}?>