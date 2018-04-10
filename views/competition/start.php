<div class="comp-teamList">
    <?$filter = $_GET['comp'] ? '&comp='.$_GET['comp'] : ''; $teamlist = $answer['teamlist']; for ($i = 0; $i < count($teamlist); $i++) {?>
        <a class="comp-teamList_item" target="_blank" href="/?r=team/view&team=<?=$teamlist[$i]['id']?><?=$filter?>">
            <img alt="<?=$teamlist[$i]['rus_name']?>" title="<?=$teamlist[$i]['rus_name']?>" class="comp-teamList_img" src="//<?=$HOST?>/upload/<?=$teamlist[$i]['logo']?>"/>
        </a>
    <?}?>
</div>
<?$res = $answer['results']; if (count($res)){?>
    <div class="comp-resultsTable">
        <?for ($i = count($res) - 1; $i >= 0 ; $i--) {?>
            <a target="_blank" class="comp-resultsTable_match" href="/?r=match/view&match=<?=$res[$i]['id']?>&comp=<?=$_GET['comp']?>">
                <div class="comp-resultsTable_header fafr-bg_dark">
                    <span class="comp-resultsTable_dateTime">
                        <?=common_dateFromSQL($res[$i]['date'], true)?>
                        <?if (strlen($res[$i]['timeh']) && strlen($res[$i]['timeh'])) {?>
                            <?=$res[$i]['timeh']?>:<?=$res[$i]['timem']?> (мск)
                        <?}?>
                    </span>
                    <span><?=$res[$i]['city']?></span>
                </div>
                <div class="comp-resultsTable_content">
                    <div class="comp-resultsTable_row">
                        <div class="comp-resultsTable_team">
                            <img class=comp-resultsTable_logo src="//<?=$HOST?>/upload/<?=$res[$i]['t1logo']?>"/>
                            <?=$res[$i]['t1name']?>
                        </div>
                        <div class="comp-resultsTable_score"><?=strlen ($res[$i]['score1']) ? $res[$i]['score1'] : '-'?></div>
                    </div>
                    <div class="comp-resultsTable_row">
                        <div class="comp-resultsTable_team">
                            <img class=comp-resultsTable_logo src="//<?=$HOST?>/upload/<?=$res[$i]['t2logo']?>"/>
                            <?=$res[$i]['t2name']?>
                        </div>
                        <div class="comp-resultsTable_score"><?=strlen ($res[$i]['score2']) ? $res[$i]['score2'] : '-'?></div>
                    </div>
                </div>
            </a>
        <?}?>
    </div>
<?}?>

<?$news = $answer['news']?>
<div class="news-tiles news-feed">
    <?php for ($i = 0; $i < 3 && $i < count($news); $i++) {?>
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