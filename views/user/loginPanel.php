<?if (!$_SESSION['userID']) {?>
    <span class="fafr-login_btn">Войти</span>
    <div class="fafr-login_form">
        <div class="fafr-login_header fafr-bg_dark">
            <div class="fafr-login_title">Войти на сайт</div>
            <div class="fafr-login_close"></div>
        </div>
        <form class="fafr-login_content" action="/?r=user/auth" method="POST">
            <div class="fafr-login_fieldWrapper">
                <input type="text" class="fafr-input fafr-login_input" placeholder="Электронная почта">
            </div>

            <div class="fafr-login_fieldWrapper">
                <input type="text" class="fafr-input fafr-login_input" placeholder="Пароль">
            </div>
        </form>
    </div>
<?} else {?>

<?}?>