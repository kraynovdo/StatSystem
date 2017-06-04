<? include '_head.php'?>
<h2>Ход игры</h2>
<script type="text/javascript">
    var $amf = $amf || {};
    $amf.teamroster = {};
    $amf.team = {
        '1' : <?=$answer['match']['team1']?>,
        '2' : <?=$answer['match']['team2']?>
    };
    $amf.teamroster[<?=$answer['match']['team1']?>] = <?print_r(json_encode($answer['team1roster']))?>;
    $amf.teamroster[<?=$answer['match']['team2']?>] = <?print_r(json_encode($answer['team2roster']))?>;
</script>
<?if (($_SESSION['userType'] >= 2) && ($_SESSION['userType'] <= 4)) {?>
    <div class="main-fieldWrapper">
        <button class="match-eventBtn main-btn roster-submit">Добавить событие</button>
    </div>
    <div class="match-eventWrapper main-hidden">
        <form method="post" action="/?r=match/createEvent">
            <input type="hidden" name="period" value="1"/>
            <input type="hidden" name="teamSt[]" value="<?=$answer['match']['team1']?>"/>
            <input type="hidden" name="team2" value="<?=$answer['match']['team2']?>"/>
            <input type="hidden" name="match" value="<?=$_GET['match']?>"/>
            <input type="hidden" name="competition" value="<?=$_GET['comp']?>"/>
            <div class="main-fieldWrapper">
                <textarea name="comment" class="match-eventComment" placeholder="Комментарий" rows="3"></textarea>
            </div>
            <div class="main-fieldWrapper">
                <select name="actionType" class="match-statsType">
                    <?$statconfig = $answer['statconfig'];?>
                    <option value="">Действие</option>
                    <?for ($i = 0; $i < count($statconfig); $i++) {?>
                        <option value="<?=$statconfig[$i]['id']?>"><?=$statconfig[$i]['name']?></option>
                    <?}?>
                </select>
            </div>
            <div class="match-statsContainer"></div>
            <button class="main-btn main-submit">Готово</button>
        </form>
    </div>
<?}?>
<?
    $event = $answer['event'];
?>
<?for ($i = 0; $i < count($event); $i++) {?>
        <div class="listview-item">
            <a class="main-delLink match-eventDelLink"
                href="/?r=match/deleteEvent&event=<?=$event[$i]['id']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">[X]</a>
            <div class="match-eventImgContainer">
                <?if ($event[$i]['team']){?>
                    <img class="match-eventImg" src="//<?=$HOST?>/upload/<?=$event[$i]['team']?>"/>
                <?}?>
            </div>
            <div class="match-eventMainInfo clearfix">
                <div class="match-eventComment"><?=$event[$i]['comment']?></div>
                <?if ($event[$i]['pg']) {?>
                    <div class="match-eventPG"><?=$event[$i]['pg']?></div>
                <?}?>
                <?if ($event[$i]['action']) {?>
                    <div class="match-eventAction"><?=$event[$i]['action']?></div>
                <?}?>
            </div>
            <div class="match-eventAddInfo">
<?
    $spArr = explode(",", $event[$i]['spname']);
    if (count($spArr)) {
        $surname = explode(",", $event[$i]['surname']);
    }
?>
            <?for ($j = 0; $j < count($spArr); $j++){?>
                <div class="match-eventChar">
                    <span><?=$spArr[$j]?></span>
                    <span><?=$surname[$j]?></span>
                </div>
            <?}?>
<?
    $scArr = explode(",", $event[$i]['scname']);
    if (count($spArr)) {
        $scvalue = explode(",", $event[$i]['scvalue']);
    }
?>
            <?for ($j = 0; $j < count($scArr); $j++){?>
                <div class="match-eventChar">
                    <span><?=$scArr[$j]?></span>
                    <span><?=$scvalue[$j]?></span>
                </div>
            <?}?>
            </div>
        </div>

<?}?>
