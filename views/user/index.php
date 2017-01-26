<h2>Пользователи</h2>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>

        <div class="listview-item<?if ($answer[$i]['user']){?> person-item_hasAcc<?}?>">
            <?=$i+1?>. <a target="_blank" href="/?r=person/view&person=<?=$answer[$i]['id']?>"><?=implode(' ', array($answer[$i]['surname'], $answer[$i]['name'], $answer[$i]['patronymic']))?></a>
        </div>
    <?}?>
</div>