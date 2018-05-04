<div class="fafr-minWidth fafr-maxWidth">
    <?if ($_SESSION['userType'] == 3) {?>
        <a class="fafr-link fafr-addLink" href="/?r=video/edit&comp=<?=$_GET['comp']?>">Добавить видео</a>
    <?}?>
    <div class="video-list_navig">
        <a href="/?r=competition/video&comp=<?=$_GET['comp']?>" class="fafr-textColor video-list_link<?if (!$_GET['cat']){?> fafr-bg_dark<?}?>">Все</a>
        <a href="/?r=competition/video&comp=<?=$_GET['comp']?>&cat=100" class="fafr-textColor video-list_link<?if ($_GET['cat'] == 100){?> fafr-bg_dark<?}?>">Матчи</a>
        <a href="/?r=competition/video&comp=<?=$_GET['comp']?>&cat=2" class="fafr-textColor video-list_link<?if ($_GET['cat'] == 2){?> fafr-bg_dark<?}?>">Лучшие моменты</a>
        <a href="/?r=competition/video&comp=<?=$_GET['comp']?>&cat=1" class="fafr-textColor video-list_link<?if ($_GET['cat'] == 1){?> fafr-bg_dark<?}?>">Обзоры</a>
    </div>
    <?$video=$answer['video']?>
    <div class="video-list">
        <?for ($i = 0; $i < count($video); $i++) {?>
        <?
            $link = $video[$i]['content'];
            if (strpos($link, 'youtu.be')) {
                $pos = strripos($link, '/');
                $code = mb_substr($link, $pos+1);
                $link = '/?r=video/view&code=' . $code . '&comp=' . $_GET['comp'] . '&video=' . $video[$i]['id'] . '&match=' . $video[$i]['mid'];
            } else if (strpos($link, 'youtube.com')) {
                $pos = strripos($link, '?v=');
                $code = mb_substr($link, $pos+3);
                $pos = strripos($code, '&');
                if ($pos && $pos > 0) {
                    $code = mb_substr($code, 0, $pos);
                }

                $link = '/?r=video/view&code=' . $code . '&comp=' . $_GET['comp'] . '&video=' . $video[$i]['id'] . '&match=' . $video[$i]['mid'];
            }
            else {
                $code = '';
            }
        ?>
            <div class="video-list_item">
                <div class="video-list_itemContent">
                    <a href="<?=$link?>" class="video-list_imgWrapper">
                        <?if ($code) {?>
                            <img class="video-list_img" src="https://img.youtube.com/vi/<?=$code?>/mqdefault.jpg"/>
                        <?} else {?>
                            <img class="video-list_img" src="//<?=$HOST?>/themes/img/empty-video.png"/>
                        <?}?>
                    </a>
                    <div class="news-date video-date_list fafr-bg_accent"><?=common_dateFromSQL($video[$i]['date'])?></div>
                    <div class="fafr-h2 video-list_title"><?=$video[$i]['title']?></div>
                    <?if ($_SESSION['userType'] == 3) {?>
                        <div class="video-list_edit">
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
</div>

