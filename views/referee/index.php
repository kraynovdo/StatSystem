<h2>Судьи</h2>
<div class="listview">
    <?php for ($i = 0; $i < count($answer); $i++) {?>

        <div class="listview-item">

            <a target="_blank" href="/?r=person/view&person=<?=$answer[$i]['id']?>"><?=implode(' ', array($answer[$i]['surname'], $answer[$i]['name'], $answer[$i]['patronymic']))?></a>
            судейство <?=$answer[$i]['exp'] ? 'с '.$answer[$i]['exp'] : 'без опыта'?>,
            игра <?=$answer[$i]['expplay'] ? 'с '.$answer[$i]['expplay'] : 'без опыта'?>
        </div>
    <?}?>
</div>