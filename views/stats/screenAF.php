<a class="main-navig2_link" href="/?r=match/playbyplayAF&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Ход игры</a>
<a class="main-navig2_link" style="font-size: 18px;" href="/?r=stats/screenAF&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Экран статиста</a>
<?
$team1 = $answer['matchInfo']['team1'];
$team2 = $answer['matchInfo']['team2'];
$teamID = $answer['teamID'];
?>
<div class="stats-screen_wrapper">
    <?if (!$IS_MOBILE) {?>
    <div class="stats-screen_column">
    <?}?>
        <div class="stats-screen_screen stats-screen_period">
            <label class="main-label_top stats-screen_commentLabel">Четверть</label>
            <?for ($i = 1; $i <= 5; $i++) {?>
                <span class="main-tile_rb">
                <input type="radio" name="period" id="period<?=$i?>" class="main-hidden"
                       value="<?= $i ?>"
                    <? if ($answer['matchInfo']['curperiod'] == $i) { ?> checked="checked"<? } ?>>
                <label class="main-tile" for="period<?=$i?>"><?= ($i == 5) ? 'Овертайм' : $i ?></label>
                </span>
            <?}?>
        </div>
        <div class="stats-screen_screen">
            <a class="main-label_top stats-screen_commentLabel">Текстовый комментарий</a>
            <textarea style="display: none" class="stats-screen_comment stats-screen_commentField" rows="2"></textarea>

            <div><span style="display: none" class="main-tile stats-screen_comment stats-screen_commentSbmt">Отправить только текст</span>
            </div>
        </div>
        <div class="stats-screen_screen stats-screen_screenMain">
            <input type="hidden" name="comp" class="stats-compId" value="<?= $_GET['comp'] ?>"/>
            <input type="hidden" name="match" class="stats-matchId" value="<?= $_GET['match'] ?>"/>
            <input type="hidden" name="team1" class="stats-team1Id" value="<?= $team1 ?>"/>
            <input type="hidden" name="team2" class="stats-team2Id" value="<?= $team2 ?>"/>

            <div class="main-fieldWrapper">
                <label class="main-label_top">Владение</label>
                <span class="main-tile_rb">
                    <input type="radio" name="team" id="team1" class="main-hidden"
                           value="<?= $team1 ?>"
                        <? if ($teamID == $team1) { ?> checked="checked"<? } ?>>
                    <label class="main-tile" for="team1"><?= $answer['matchInfo']['t1name'] ?></label>
                </span>
                <span class="main-tile_rb">
                    <input type="radio" name="team" id="team2" class="main-hidden"
                           value="<?= $team2 ?>"
                        <? if ($teamID == $team2) { ?> checked="checked"<? } ?>>
                    <label class="main-tile" for="team2"><?= $answer['matchInfo']['t2name'] ?></label>
                </span>
            </div>

            <? $qbRoster = $answer['rosters'][$team1]['qb'];
            $team = $team1 ?>
            <? include 'screenAF/_qbChoose.php' ?>

            <? $qbRoster = $answer['rosters'][$team2]['qb'];
            $team = $team2 ?>
            <? include 'screenAF/_qbChoose.php' ?>
            <input type="button" class="main-tile stats-screen_qbAdd" value="+ Другой QB"/>


            <div class="main-fieldWrapper">
                <label class="main-label_top">Действие</label>
                <? $statconfig = $answer['statconfig']; ?>
                <? for ($i = 0; $i < count($statconfig); $i++) { ?>
                    <div class="main-tile stats-screen_action stats-screen_success"
                         data-id="<?= $statconfig[$i]['id'] ?>"><?= $statconfig[$i]['name'] ?></div>
                <? } ?>
            </div>
        </div>
        <? $fullRoster = $answer['rosters'][$team1];
        $team = $team1 ?>
        <? include 'screenAF/_fullRoster.php' ?>

        <? $fullRoster = $answer['rosters'][$team2];
        $team = $team2 ?>
        <? include 'screenAF/_fullRoster.php' ?>

        <div class="stats-screen_char stats-screen_screen" style="display: none;">
            <input type="hidden" name="statactiontype"/>

            <div class="stats-screen_charContent"></div>
        </div>
    <?if (!$IS_MOBILE) {?>
    </div>
    <?$event = $answer['event']?>

    <div class="stats-screen_column stats-screen_events">
        <? include $_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/match/_eventListAF.php';?>
    </div>
    <?}?>
</div>