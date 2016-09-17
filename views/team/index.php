<h2>Команды</h2>
<div class="listview">
<?$filter = $_GET['comp'] ? '&comp='.$_GET['comp'] : ''?>
<?php for ($i = 0; $i < count($answer); $i++) {?>
    <div class="listview-item">
        <a target="_blank" href="/?r=team/view&team=<?=$answer[$i]['id']?><?=$filter?>">
<?
    if ($answer[$i]['age_id'] != 21) {
        $age = ' ('.$answer[$i]['age'].')';
    }
    else {
        $age = '';
    }
?>
        <?=$answer[$i]['rus_name']?>
        </a>
        <?=$answer[$i]['city']?><?=$age?>
    </div>
<?}?>
</div>