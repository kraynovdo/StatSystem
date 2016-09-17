<h2>Мои команды</h2>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>
        <div class="listview-item">
            <a target="_blank" href="//<?=$HOST?>/?r=team/request&team=<?=$answer[$i]['team']?>"><?=$answer[$i]['rus_name']?></a>
        </div>
    <?}?>
</div>