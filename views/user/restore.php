<h2>Восстановление пароля</h2>
<form method="POST" action="/?r=user/restorepass">
    <div>Новый пароль</div>
    <input class="user-password main-password" type="password" name="password"/>
    <div>Подтверждение</div>
    <input class="user-password main-password_confirm" data-validate="password" type="password" name="passwordConfirm"/>
    <input type="hidden" name="id" value="<?=$answer?>"/>
    <div>
        <input class="main-btn main-submit" type="button" value="Сохранить"/>
    </div>
</form>