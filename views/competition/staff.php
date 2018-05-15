<div class="fafr-minWidth fafr-maxWidth">
    <?if ($_SESSION['userType'] == 3) {?>
        <a class="fafr-link" href="/?r=usercomp/add&comp=<?=$_GET['comp']?>&ret=competition/staff">Добавить лицо</a>
    <?}?>
    <div class="comp-persons_list">
        <?$users = $answer['usercomp'];for($i = 0; $i < count($users); $i++) {?>
        <div class="comp-persons_item">
            <div class="comp-persons_photo">
                <?if ($users[$i]['avatar']) {?>
                    <img style="width:100%" src="//<?=$HOST?>/upload/<?=$users[$i]['avatar']?>">
                <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                <?}?>
            </div>
            <div class="comp-persons_info">
                <div class="comp-persons_fio">
                    <?=$users[$i]['surname'] . ' ' . $users[$i]['pname'] . ' ' . $users[$i]['patronymic']?>
                </div>
                <div class="comp-persons_work"><?=$users[$i]['work']?></div>
                <div class="comp-persons_phone"><?=common_phone($users[$i]['phone'])?></div>
            </div>
            <?if ($_SESSION['userType'] == 3) {?>
            <a class="fafr-link main-dellink" href="/?r=usercomp/delete&comp=<?=$_GET['comp']?>&ret=competition/staff&uc=<?=$users[$i]['id']?>">[x]</a>
            <?}?>
        </div>
        <?}?>
    </div>
</div>