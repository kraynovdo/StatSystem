<h2>Виды действий для статистики</h2>
<h3>Тут пока ничего менять не надо, а то сломаете статистику!</h3>
<a class="main-addLink" href="/?r=statconfig/add">Добавить действие</a>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <a href="/?r=statconfig/edit&type=<?=$answer[$i]['id']?>"><?=$answer[$i]['name']?></a>
            <a class="main-delLink" href="/?r=statconfig/delete&type=<?=$answer[$i]['id']?>">[X]</a>
        </div>
    <?}?>
</div>