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
    <h2><?=$answer['title']?></h2>
    <div class="material-content"><?=$answer['content']?></div>
    <div class="material-date"><?=common_dateFromSQL($answer['date'])?></div>

    <?if (($_SESSION['userID'] == $answer['user']) || ($_SESSION['userType'] == 3)) {?>
        <a href="/?r=material/edit&mater=<?=$answer['id']?><?=$filter?>&ret=<?=$_GET['ret']?>">Редактировать</a>
        <form action="/?r=material/delete" method="POST" class="main-delForm">
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
            <input class="main-btn" type="submit" value="Удалить"/>
        </form>
    <?}?>
<?} else {?>
    Материал не найден
<?}?>