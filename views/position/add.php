<h2>Добавление игровой позиции</h2>
<form action="/?r=position/create" method="POST">
    <p>
        <input name="name" type="text" placeholder="Название" data-validate="req"/>
    </p>
    <p>
        <input name="rus_name" type="text" placeholder="Название по-русски"  data-validate="req"/>
    </p>

    <p>
        <input name="abbr" type="text" placeholder="Сокращение"  data-validate="req"/>
    </p>
    <input class="main-btn main-submit" type="button" value="Сохранить"/>
</form>