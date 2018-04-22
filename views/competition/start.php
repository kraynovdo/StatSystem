<div class="fafr-minWidth fafr-maxWidth">
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
                <a target="_blank" class="comp-resultsTable_match" href="/?r=matchcenter&match=<?=$res[$i]['id']?>&comp=<?=$_GET['comp']?>">
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

    <?$video = $answer['livevideo']?>
    <div class="comp-live">
        <?for ($i = 0; $i < count($video); $i++) {?>
        <?
        $link = $video[$i]['content'];
        if (strpos($link, 'youtu.be')) {
            $pos = strripos($link, '/');
            $code = mb_substr($link, $pos+1);
            $editor = '<iframe width="100%" height="280px" src="https://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
        }
        else {
            $editor = '';
        }
        ?>
        <div class="comp-live_item">
            <div class="comp-live_itemContent">
                <?=$editor?>
                <div class="news-date live-date_list fafr-bg_accent">LIVE</div>
                <div class="fafr-h2 comp-live_title"><?=$video[$i]['title']?></div>
                <?if ($_SESSION['userType'] == 3) {?>
                <div class="comp-live_edit">
                    <?if (($video[$i]['id'] != -1)) {?>
                        <a class="fafr-link" href="/?r=video/edit&video=<?=$video[$i]['id']?>&comp=<?=$_GET['comp']?>">[ред]</a>
                        <a class="fafr-link main-dellink" href="/?r=video/delete&video=<?=$video[$i]['id']?>&comp=<?=$_GET['comp']?>">[x]</a>
                    <?} else {?>
                        <a class="fafr-link" href="/?r=matchcenter&match=<?=$video[$i]['mid']?>&comp=<?=$_GET['comp']?>">[ред]</a>
                    <?}?>
                </div>
                <?}?>
            </div>

        </div>
        <?}?>
    </div>

    <?$news = $answer['news']?>
    <div class="feed-container">
        <? if (count($news)) {?>
            <div class="feed-column">
                <?php for ($i = 0; $i < 3 && $i < count($news); $i++) {?>
                    <div class="feed-column_item <?if ($i == 3){?> feed-column_item_last<?}?>">
                        <?if ($i == 0) {?><a class="fafr-link feed-link" href="/?r=competition/news&comp=<?=$_GET['comp']?>">Все новости</a><?}?>
                        <div class="feed-column_date fafr-textAdd"><?=common_dateFromSQL($news[$i]['date'])?></div>
                        <h2 class="fafr-h2 feed-column_title">
                            <a class="fafr-textColor" href="/?r=material/view&mater=<?=$news[$i]['material']?><?=$filter?>&ret=competition/news"><?=$news[$i]['title']?></a>
                        </h2>

                        <div class="feed-column_desc">
                            <?=nl2br($news[$i]['preview']);?>
                        </div>
                        <div class="feed-column_gradient"></div>
                    </div>
                <?}?>
            </div>
        <?}?>
        <? if (count($news)) {?>
            <div class="feed-main <? if (count($news)) {?> feed-main_withCol<?}?>">
                <div class="feed-main_img">
                    <?if ($news[0]['image']) {?>
                        <img style="width:100%" src="//<?=$HOST?>/upload/<?=$news[0]['image']?>">
                    <?} else {?>
                        <img style="width:100%" src="//<?=$HOST?>/themes/img/empty-new.png">
                    <?}?>
                </div>
                <div class="feed-main_text">
                    <div class="news-date feed-date_main fafr-bg_accent"><?=common_dateFromSQL($news[0]['date'])?></div>
                    <div class="feed-main_title">
                        <a class="fafr-lightColor" href="/?r=material/view&mater=<?=$news[0]['material']?><?=$filter?>&ret=competition/news"><?=$news[0]['title']?></a>
                    </div>
                    <div class="feed-main_desc">
                        <?=nl2br($news[0]['preview']);?>
                    </div>
                </div>
            </div>
        <?}?>

    </div>
</div>