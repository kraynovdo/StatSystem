<div class="fafr-minWidth fafr-maxWidth">
    <div class="comp-teamList">
        <?$filter = $_GET['comp'] ? '&comp='.$_GET['comp'] : ''; $teamlist = $answer['teamlist']; for ($i = 0; $i < count($teamlist); $i++) {?>
            <a class="comp-teamList_item" target="_blank" href1="/?r=team/view&team=<?=$teamlist[$i]['id']?><?=$filter?>">
                <img alt="<?=$teamlist[$i]['rus_name']?>" title="<?=$teamlist[$i]['rus_name']?>" class="comp-teamList_img" src="//<?=$HOST?>/upload/<?=$teamlist[$i]['logo']?>"/>
            </a>
        <?}?>
    </div>
    <?$res = $answer['results']; if (count($res)){?>
        <div class="comp-resultsTable">
            <?for ($i = count($res) - 1; $i >= 0 ; $i--) {?>
                <a class="comp-resultsTable_match" href="/?r=matchcenter&match=<?=$res[$i]['id']?>&comp=<?=$_GET['comp']?>">
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
            $editor = common_getPlayer($link, 450, 280);
        ?>
        <div class="comp-live_item">
            <div class="comp-live_itemContent">
                <?=$editor?>
                <div class="news-date live-date_list fafr-bg_accent">LIVE</div>
                <div class="fafr-h2 comp-live_title"><?=$video[$i]['title']?></div>
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
                <?php for ($i = 0; $i < 3 && $i < count($news); $i++) {?>
                <div class="feed-main_item feed-main_item_<?=$i?><?if ($i > 0) {?> fafr-hidden<?}?>">
                    <div class="feed-main_img">
                        <?if ($news[$i]['image']) {?>
                            <img style="width:100%" src="//<?=$HOST?>/upload/<?=$news[$i]['image']?>">
                        <?} else {?>
                            <img style="width:100%" src="//<?=$HOST?>/themes/img/empty-new.png">
                        <?}?>
                    </div>
                    <div class="feed-main_text">
                        <div class="news-date feed-date_main fafr-bg_accent"><?=common_dateFromSQL($news[$i]['date'])?></div>
                        <div class="feed-main_title">
                            <a class="fafr-lightColor" href="/?r=material/view&mater=<?=$news[$i]['material']?><?=$filter?>&ret=competition/news"><?=$news[$i]['title']?></a>
                        </div>
                        <div class="feed-main_desc">
                            <?=nl2br($news[$i]['preview']);?>
                        </div>
                    </div>
                </div>
                <?}?>
            </div>
        <?}?>

    </div>

    <div class="comp-leaders">
        <h1 class="fafr-h1">Лидеры</h1>
        <a class="fafr-link feed-link comp-leaders_link" href="/?r=competition/stats&comp=<?=$_GET['comp']?>">Вся статистика</a>
        <div class="comp-leaders_list">
            <?
            $arrRush1 = $answer['stats']['rush'];
            $arrPass1 =$answer['stats']['pass'];
            $arrQb1 = $answer['stats']['qb'];
            $arrRet1 = $answer['stats']['ret'];
            $arrTac1 = $answer['stats']['tac'];
            $arrSack1 = $answer['stats']['sack'];
            $arrInt1 = $answer['stats']['int'];
            $arrFg1 = $answer['stats']['fg'];
            ?>

            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">Пас</div>
                <div class="comp-leaders_content">
                    <?if ($arrQb1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrQb1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">Вынос</div>
                <div class="comp-leaders_content">
                    <?if ($arrRush1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrRush1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">Прием</div>
                <div class="comp-leaders_content">
                    <?if ($arrPass1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrPass1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">Перехваты</div>
                <div class="comp-leaders_content">
                    <?if ($arrInt1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrInt1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">Сэки</div>
                <div class="comp-leaders_content">
                    <?if ($arrSack1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrSack1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">Захваты</div>
                <div class="comp-leaders_content">
                    <?if ($arrTac1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrTac1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">Возврат</div>
                <div class="comp-leaders_content">
                    <?if ($arrRet1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrRet1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
            <div class="comp-leaders_item">
                <div class="comp-leaders_sign fafr-bg_dark">По воротам</div>
                <div class="comp-leaders_content">
                    <?if ($arrFg1[0]['avatar']) {?>
                    <img style="width: 70px;" src="//<?=$HOST?>/upload/<?=$arrFg1[0]['avatar']?>">
                    <?} else {?>
                    <div class="fafr-noPhoto">?</div>
                    <?}?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="fafr-minWidth fafr-bg_dark">
    <div class="fafr-minWidth fafr-maxWidth">
        <h1 class="fafr-h1">Видео</h1>
        <div class="news-tiles fafr-3columns">
            <div class="fafr-3columnsWrapper">
                <?for ($i = 0, $video = $answer['videofeed']; $i < count($video); $i++) {?>
                <?
                    $link = $link = '/?r=video/view&comp=' . $_GET['comp'] . '&video=' . $video[$i]['id'] . '&match=' . $video[$i]['mid'];;
                    $code = common_youtubeCode($video[$i]['content']);
                ?>
                <div class="video-list_item fafr-3columns_item">
                    <div class="video-list_itemContent">
                        <a href="<?=$link?>" class="video-list_imgWrapper">
                            <?if ($code) {?>
                                <img class="video-list_img" src="https://img.youtube.com/vi/<?=$code?>/mqdefault.jpg"/>
                            <?} else {?>
                                <img class="video-list_img" src="//<?=$HOST?>/themes/img/empty-video.png"/>
                            <?}?>
                        </a>
                        <div class="news-date video-date_list fafr-bg_accent"><?=common_dateFromSQL($video[$i]['date'])?></div>
                    </div>

                </div>
                <?}?>
            </div>
        </div>
    </div>
</div>