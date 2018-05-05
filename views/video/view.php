<div class="fafr-minWidth fafr-maxWidth">
    <a class="fafr-backLink fafr-textColor" href="javascript: history.back()">Назад</a>
</div>

<div class="news-last fafr-bg_dark fafr-minWidth">
    <div class="fafr-minWidth fafr-maxWidth">
        <div class="video-view_img">
            <?if ($answer['player']) {?><?=$answer['player']?><?}?>
        </div>
        <div class="video-view_text">
            <div class="news-last_title">
                <?=$answer['title']?>
            </div>
            <div class="news-last_desc">
                <?=nl2br($answer['preview']);?>
            </div>
        </div>
    </div>
</div>