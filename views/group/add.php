<h2>Добавление дивизиона</h2>
<form action="/?r=group/create" method="POST">
    <input type="hidden" value="<?=$_GET['comp']?>" name="comp"/>
    <p>
        <input name="name" type="text" placeholder="Название" data-validate="req"/>
    </p>
    <input class="main-btn main-submit" type="button" value="Сохранить"/>
</form>