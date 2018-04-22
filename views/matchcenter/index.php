<div class="match-header">
    <div class="fafr-minWidth fafr-bg_dark match-bg">
        <div class="fafr-minWidth fafr-maxWidth">
            <div class="match-header_content">
                <div class="match-header_info">
                    <div class="match-header_date fafr-centerAl">
                        <?=common_dateFromSQL($answer['maininfo']['date'])?>
                        <?if (strlen($answer['maininfo']['timeh']) && strlen($answer['maininfo']['timeh'])) {?>
                            <?=$answer['maininfo']['timeh']?>:<?=$answer['maininfo']['timem']?> (мск)
                        <?}?>
                    </div>
                    <div class="match-header_place fafr-centerAl">
                        <?if ($answer['maininfo']['city']) {?>
                            <?=$answer['maininfo']['city']?>
                        <?}?>
                        <?if ($answer['maininfo']['group']) {?>
                            <?=$answer['maininfo']['group']?>
                        <?}?>
                    </div>
                    <div class="match-header_count">
                        <span class="match-header_digit">
                            <?if (strlen($answer['maininfo']['score1'])) {?><?=$answer['maininfo']['score1']?><?} else {?>-<?}?>
                        </span>
                        <span class="match-header_digitPadding"></span>
                        <span class="match-header_digit">
                            <?if (strlen($answer['maininfo']['score2'])) {?><?=$answer['maininfo']['score2']?><?} else {?>-<?}?>
                        </span>
                    </div>
                </div>
                <div class="match-header_team match-header_team_left">
                    <div class="match-header_logo">
                        <?if ($answer['maininfo']['t1logo']) {?>
                            <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['maininfo']['t1logo']?>">
                        <?} else {?>
                            <div class="fafr-noPhoto">?</div>
                        <?}?>
                    </div>
                    <div class="match-header_teamCity"><?=$answer['maininfo']['t1city_adj']?></div>
                    <div class="match-header_teamName"><?=$answer['maininfo']['t1name']?></div>
                </div>
                <div class="match-header_team match-header_team_right">
                    <div class="match-header_logo">
                        <?if ($answer['maininfo']['t2logo']) {?>
                            <img style="width:100%" src="//<?=$HOST?>/upload/<?=$answer['maininfo']['t2logo']?>">
                        <?} else {?>
                            <div class="fafr-noPhoto">?</div>
                        <?}?>
                    </div>
                    <div class="match-header_teamCity fafr-rightAl"><?=$answer['maininfo']['t2city_adj']?></div>
                    <div class="match-header_teamName fafr-rightAl"><?=$answer['maininfo']['t2name']?></div>
                </div>
            </div>

        </div>

    </div>
    <div class="match-bg_image"></div>
</div>

<div class="fafr-minWidth fafr-maxWidth">
    <?if ($answer['maininfo']['video']) { $video = str_replace("\"", "\\\"", $answer['maininfo']['video']);?>
        <div class="match-video fafr-centerAl">
            <?if (strpos($video, 'youtu.be')) {
                $pos = strripos($video, '/');
                $code = mb_substr($video, $pos+1);
                $editor = '<iframe width="680px" height="375px" src="https://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
            } else {
                $editor = '';
            }?>

        <?if ($editor) {?>
            <?=$editor?>
        <?} else {?>
            <a class="fafr-link" target="_blank" href="<?=$video?>">Видео</a>
        <?}?>

        </div>
    <?}?>
    <?if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['match']['team1']]) || ($_SESSION['userTeams'][$answer['match']['team2']]) || ($_SESSION['userComp'][$_GET['comp']] == 1)){?>
    <div class="match-video_admin fafr-centerAl">
        <?if ($video) {?>
            <a class="fafr-link match-videoEdit" href="javascript: void(0);">(Редактировать ссылку)</a>
        <?} else {?>
            <a class="fafr-link match-videoEdit" href="javascript: void(0);">Добавить ссылку на видео</a>
        <?}?>
        <form method="POST" action="/?r=match/videoupdate" class="fafr-hidden match-videoForm">
            <input type="hidden" name="match" value="<?=$_GET['match']?>"/>
            <input type="hidden" name="ret" value="matchcenter"/>
            <input type="hidden" name="competition" value="<?=$_GET['comp']?>"/>
            <input class="fafr-input match-videoField" type="text" name="video" value="<?=$video?>"/>
            <input type="button" class="fafr-btn fafr-btn_standart main-submit" value="ok"/>
        </form>
    </div>
    <?}?>
</div>