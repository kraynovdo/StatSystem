<?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>
<div class="referee-addBlock">
    <button class="referee-compAddBtn main-btn roster-submit">Добавить</button>
</div>
<form class="referee-compAddForm fafr-hidden" action="/?r=refereecomp/create" method="post">
    <input name="competition" type="hidden" value="<?=$_GET['comp']?>"/>
    <input type="hidden" name="ret" value="competition/referee"/>
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
<div class="referee-list">
    <?php for ($i = 0; $i < count($answer['referee']); $i++) {?>
        <div class="referee-item">
            <div class="referee-item_content">
                <a class="comp-columnContentLink" target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?>"></a>
                <?if ($answer['referee'][$i]['avatar']) {?>
                    <span class="referee-clAvatar" target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?><?=$filter?>">
                        <img style="width:140px" src="//<?=$HOST?>/upload/<?=$answer['referee'][$i]['avatar']?>">
                    </span>
                <?} else {?>
                    <span class="referee-clAvatar" target="_blank" href="/?r=person/view&person=<?=$answer['referee'][$i]['id']?><?=$filter?>">
                        <div class="fafr-noPhoto">?</div>
                    </span>
                <?}?>

                <div class="referee-item_info">

                    <div class="referee-fio">
                        <?=implode(' ', array($answer['referee'][$i]['surname'], $answer['referee'][$i]['name'], $answer['referee'][$i]['patronymic']))?>
                    </div>

                    <?=$answer['referee'][$i]['country']?>


                </div>
            </div>
            <?if (($_SESSION['userType'] == 3) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {?>

            <a class="main-dellink" href="/?r=refereecomp/delete&ret=competition/referee&rc=<?=$answer['referee'][$i]['rc']?>&comp=<?=$_GET['comp']?>">[X]</a>

            <?}?>
        </div>
    <?}?>
</div>
