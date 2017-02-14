<h2>Выберите команду для подачи заявки</h2>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <a target="_blank" href="/?r=request/fill&comp<?=$_GET['comp']?>&team=<?=$answer[$i]['team']?>"><?=$answer[$i]['rus_name']?></a>
        </div>
    <?}?>
</div>