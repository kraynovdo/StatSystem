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
                $editor = '<iframe width="100%" height="200px" src="https://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
            }
            else {
                $editor = '';
            }
        ?>
            <div class="video-list_item">
                <div class="video-list_itemContent">
                    <?=$editor?>
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

