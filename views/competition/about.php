<div class="fafr-minWidth fafr-maxWidth">
    <div class="comp-about_info">
        <div class="comp-about_logo">
            <?if ($answer['org']['logo']) {?>
                <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['org']['logo']?>">
            <?} else {?>
                <div class="fafr-noPhoto">?</div>
            <?}?>
        </div>
        <div class="comp-about_text">
            <h1 class="fafr-h1"><?=$answer['org']['name']?></h1>
            <div class="comp-about_desc">
                <?=nl2br($answer['org']['desc'])?>
            </div>
        </div>
    </div>
    <?if ($_SESSION['userType'] == 3) {?>
        <a class="fafr-link" href="/?r=organization/edit&org=<?=$answer['org']['id']?>&ret=competition/about&comp=<?=$_GET['comp']?>">Редактировать информацию</a>
    <?}?>
</div>
<div class="fafr-bg_dark comp-persons fafr-minWidth">
    <div class="fafr-minWidth fafr-maxWidth">
        <h1 class="fafr-h1">Руководство лиги</h1>
        <?if ($_SESSION['userType'] == 3) {?>
            <a class="fafr-link" href="/?r=usercomp/add&comp=<?=$_GET['comp']?>&ret=competition/about">Добавить лицо</a>
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
                        <a class="fafr-link main-dellink" href="/?r=usercomp/delete&comp=<?=$_GET['comp']?>&ret=competition/about&uc=<?=$users[$i]['id']?>">[x]</a>
                    <?}?>
                </div>
            <?}?>
        </div>
    </div>
</div>
<div class="fafr-minWidth fafr-maxWidth">
    <h1 class="fafr-h1">Контакты</h1>
    <span class="comp-about_phone">
        <span class="comp-about_label">Телефон:</span>
        <?=common_phone($answer['org']['phone'])?>
    </span>

    <span class="comp-about_email">
        <span class="comp-about_label">email:</span>
        <?=common_phone($answer['org']['email'])?>
    </span>

    <div class="comp-about_address">
        <span class="comp-about_label">Адрес:</span>
        <?=common_phone($answer['org']['address'])?>
    </div>
<div>