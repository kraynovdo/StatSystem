<div class="fafr-minWidth fafr-maxWidth">
<?php if (count($answer)) {?>
<?
    $filter = '';
    if ($_GET['comp']) {
        $filter .= '&comp='.$_GET['comp'];
    }
    if ($_GET['team']) {
        $filter .= '&team='.$_GET['team'];
    }
    if ($_GET['federation']) {
        $filter .= '&federation='.$_GET['federation'];
    }
?>
    <a class="fafr-backLink fafr-textColor" href="javascript: history.back()">Назад</a>
</div>

<div class="news-last fafr-bg_dark fafr-minWidth">
    <div class="fafr-minWidth fafr-maxWidth">
        <div class="news-last_img">
            <?if ($answer['image']) {?>
                <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['image']?>">
            <?} else {?>
                <img style="width:100%" src="//<?=$HOST?>/themes/img/empty-new.png">
            <?}?>
            <div class="news-date news-date_last fafr-bg_accent"><?=common_dateFromSQL($answer['date'])?></div>
        </div>
        <div class="news-last_text">
            <div class="news-last_title">
                <?=$answer['title']?>
            </div>
            <div class="news-last_desc">
                <?=nl2br($answer['preview']);?>
            </div>
        </div>
    </div>
</div>


<div class="fafr-minWidth fafr-maxWidth">

    <div class="material-content"><?=$answer['content']?></div>
    <div>
        <a class="fafr-toTopLink fafr-textColor" href="#top">Наверх</a>
    </div>
    <?if (($_SESSION['userID'] == $answer['user']) || ($_SESSION['userType'] == 3)) {?>
        <a class="fafr-link" href="/?r=material/edit&mater=<?=$answer['id']?><?=$filter?>&ret=<?=$_GET['ret']?>">Редактировать</a>
        <form action="/?r=material/delete" method="POST" class="main-delForm material-delForm">
            <input type="hidden" name="mater" value="<?=$answer['id']?>"/>
            <input type="hidden" name="ret" value="<?=$_GET['ret']?>"/>
            <?if ($_GET['comp']){?>
                <input type="hidden" name="comp" value="<?=$_GET['comp']?>"/>
            <?}?>
            <?if ($_GET['team']){?>
                <input type="hidden" name="team" value="<?=$_GET['team']?>"/>
            <?}?>
            <?if ($_GET['federation']){?>
                <input type="hidden" name="federation" value="<?=$_GET['federation']?>"/>
            <?}?>
            <input class="main-btn fafr-btn fafr-btn_primary" type="submit" value="Удалить"/>
        </form>
    <?}?>
<?} else {?>
    Материал не найден
<?}?>
</div>