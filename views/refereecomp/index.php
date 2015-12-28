<h2>Судьи</h2>
<?if ($_SESSION['userType'] == 3) {?>
    <div class="main-fieldWrapper">
        <button class="referee-compAddBtn main-btn roster-submit">Добавить</button>
    </div>
    <form class="referee-compAddForm main-hidden" action="/?r=refereecomp/create" method="post">
        <input name="competition" type="hidden" value="<?=$_GET['comp']?>"/>
        <div class="main-fieldWrapper">
            <select class="referee-compAddField" name="referee">
            <?php for ($i = 0; $i < count($answer['all']); $i++) {?>
                <option value="<?=$answer['all'][$i]['refid']?>"><?=implode(' ', array($answer['all'][$i]['surname'], $answer['all'][$i]['name'], $answer['all'][$i]['patronymic']))?></option>
            <?}?>
            </select>
        </div>
        <div class="main-fieldWrapper">
            <label>
                <input type="checkbox" name="main"/>
                Главный судья соревнований
            </label>
        </div>
        <div class="main-fieldWrapper">
            <input type="button" class="main-btn main-submit" value="ок"/>
        </div>
    </form>
<?}?>
<div class="listview">
    <?php for ($i = 0; $i < count($answer['referee']); $i++) {?>
        <div class="listview-item">
            <a target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?>"><?=implode(' ', array($answer['referee'][$i]['surname'], $answer['referee'][$i]['name'], $answer['referee'][$i]['patronymic']))?></a>
            судейство <?=$answer['referee'][$i]['exp'] ? 'с '.$answer['referee'][$i]['exp'] : 'без опыта'?>,
            игра <?=$answer['referee'][$i]['expplay'] ? 'с '.$answer['referee'][$i]['expplay'] : 'без опыта'?>
            <a class="main-dellink" href="/?r=refereecomp/delete&rc=<?=$answer['referee'][$i]['rc']?>&comp=<?=$_GET['comp']?>">[X]</a>
        </div>
    <?}?>
</div>