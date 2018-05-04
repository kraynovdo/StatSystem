<div class="fafr-minWidth fafr-maxWidth">
    <a class="fafr-backLink fafr-textColor" href="javascript: history.back()">Назад</a>
</div>
<?
    $link = $answer['content'];
    if (strpos($link, 'youtu.be')) {
        $pos = strripos($link, '/');
        $code = mb_substr($link, $pos+1);
    }
    else if (strpos($link, 'youtube.com')) {
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

<div class="news-last fafr-bg_dark fafr-minWidth">
    <div class="fafr-minWidth fafr-maxWidth">
        <div class="video-view_img">
            <iframe width="640" height="360" src="https://www.youtube.com/embed/<?=$code?>" frameborder="0" allowfullscreen></iframe>
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