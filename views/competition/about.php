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