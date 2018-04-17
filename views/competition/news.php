<?
$news=$answer['news'];
$filter = '';
$access = $_SESSION['userType'] == 3;
if ($_GET['comp']) {
    $filter .= '&comp='.$_GET['comp'];
    $access = $_SESSION['userType'] == 3;
}
if ($_GET['team']) {
    $filter .= '&team='.$_GET['team'];
    $access = ($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$_GET['team']]);
}

if ($_GET['federation']) {
    $filter .= '&federation='.$_GET['federation'];
    $access = ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']]);
}
?>
<div class="fafr-minWidth fafr-maxWidth">
    <?if ($access) {?>
        <a class="fafr-link main-addLink" href="/?r=material/add<?=$filter?>&ret=competition/news">Добавить новость</a>
    <?}?>
</div>

<?php for ($i = 0; $i < 1 && $i < count($news); $i++) {?>
    <div class="news-last fafr-bg_dark fafr-minWidth">
        <div class="fafr-minWidth fafr-maxWidth">
            <div class="news-last_img">
                <?if ($news[$i]['image']) {?>
                    <img style="width:100%" src="//<?=$HOST?>/upload/<?=$news[$i]['image']?>">
                <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                <?}?>
                <div class="news-date news-date_last fafr-bg_accent"><?=common_dateFromSQL($news[$i]['date'])?></div>
            </div>
            <div class="news-last_text">
                <div class="news-last_title">
                    <a class="fafr-lightColor" href="/?r=material/view&mater=<?=$news[$i]['material']?><?=$filter?>&ret=competition/news"><?=$news[$i]['title']?></a>
                </div>
                <div class="news-last_desc">
                    <?=nl2br($news[$i]['preview']);?>
                </div>
            </div>
        </div>
    </div>
<?}?>
<div class="fafr-minWidth fafr-maxWidth">
    <div class="news-tiles">
        <?php for ($i = 1; $i < 4 && $i < count($news); $i++) {?>
            <div class="news-tile <?if ($i == 2){?> news-tile_center<?}?>">
                <div class="news-tile_content">
                    <div class="news-tile_img">
                        <?if ($news[$i]['image']) {?>
                            <img style="width:100%" src="//<?=$HOST?>/upload/<?=$news[$i]['image']?>">
                        <?} else {?>
                            <div class="fafr-noPhoto">?</div>
                        <?}?>
                        <div class="news-date news-date_tile fafr-bg_accent"><?=common_dateFromSQL($news[$i]['date'])?></div>
                    </div>
                    <div class="news-tile_text">
                        <div class="news-tile_title">
                            <a class="fafr-textColor" href="/?r=material/view&mater=<?=$news[$i]['material']?><?=$filter?>&ret=competition/news"><?=$news[$i]['title']?></a>
                        </div>
                        <div class="news-tile_desc">
                            <?=nl2br($news[$i]['preview']);?>
                        </div>
                    </div>
                </div>
            </div>
        <?}?>
    </div>

    <div class="news-list">
        <?php for ($i = 4; $i < count($news); $i++) {?>
        <div class="news-list_item">
            <div class="news-list_title">
                <a class="fafr-textColor" href="/?r=material/view&mater=<?=$news[$i]['material']?><?=$filter?>&ret=competition/news"><?=$news[$i]['title']?></a>
            </div>
            <div class="news-list_desc">
                <?=nl2br($news[$i]['preview']);?>
            </div>
            <div class="news-list_date fafr-textAdd"><?=common_dateFromSQL($news[$i]['date'])?></div>
        </div>
        <?}?>
    </div>
</div>