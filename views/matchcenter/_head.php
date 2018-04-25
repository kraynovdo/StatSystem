<?

    if (($_SESSION['userType'] == 3) || ($_SESSION['userType'] == 4)) {
        $FULLACCESS = true;
        $STATACCESS = true;
    }
    else {
        if ($_SESSION['userType'] == 5) {
            $STATACCESS = true;
        }
        else {
            if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['maininfo']['team1']]) || ($_SESSION['userComp'][$_GET['comp']] == 1) ) {
                $T1ACCESS = true;
            }
            if (($_SESSION['userType'] == 3) || ($_SESSION['userTeams'][$answer['maininfo']['team2']]) || ($_SESSION['userComp'][$_GET['comp']] == 1)) {
                $T2ACCESS = true;
            }
        }
    }

?>
<div class="match-header">
    <? if ($T1ACCESS || $T2ACCESS || $FULLACCESS || $STATACCESS) {?>
    <div class="fafr-minWidth fafr-maxWidth fafr-centerAl match-refAdmin">
        <?if ($FULLACCESS) {?>
            <a class="fafr-link match-admin_link" href="/?r=protocol/edit&comp=<?=$_GET['comp']?>&match=<?=$_GET['match']?>&ret=matchcenter">Заполнить протокол</a>
            <a class="fafr-link match-admin_link" href="/?r=action/edit&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&ret=matchcenter">Заполнить очки</a>
            <a class="fafr-link match-admin_link" href="/?r=matchroster/refcheck&ret=matchcenter&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&ret=matchcenter&team=<?=$answer['maininfo']['team1']?>">Управление составами</a>
        <?}?>
        <?if ($STATACCESS) {?>
            <a class="fafr-link match-admin_link" href="/?r=stats/screenAF&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Экран статиста</a>
        <?}?>
        <?if ($T1ACCESS) {?>
            <a class="fafr-link match-admin_link" href="/?r=matchroster/refcheck&ret=matchcenter&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&ret=matchcenter&team=<?=$answer['maininfo']['team1']?>">Управление составами</a>
        <?}?>
        <?if ($T2ACCESS) {?>
            <a class="fafr-link match-admin_link" href="/?r=matchroster/refcheck&ret=matchcenter&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>&ret=matchcenter&team=<?=$answer['maininfo']['team2']?>">Управление составами</a>
        <?}?>
    </div>
    <?}?>
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
    <div class="match-bg_image<? if ($FULLACCESS || $T1ACCESS || $T2ACCESS || $STATACCESS) {?> match-bg_image_pad<?}?>"></div>
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

    <a name="nav"></a>
    <div class="match-navig">
        <a href="/?r=matchcenter&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>#nav" class="match-navig_link <?if ($_GET['r'] == 'matchcenter'){?> match-navig_link_selected<?}?>">Набранные очки</a>
        <a href="/?r=matchcenter/protocol&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>#nav" class="match-navig_link <?if ($_GET['r'] == 'matchcenter/protocol'){?> match-navig_link_selected<?}?>">Протокол матча</a>
        <a href="/?r=matchcenter/roster&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>#nav" class="match-navig_link <?if ($_GET['r'] == 'matchcenter/roster'){?> match-navig_link_selected<?}?>">Составы команд</a>
        <a href="/?r=matchcenter/stats&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>#nav" class="match-navig_link <?if ($_GET['r'] == 'matchcenter/stats'){?> match-navig_link_selected<?}?>">Статистика</a>
    </div>
</div>