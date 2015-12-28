<?=$answer['match']['date']?>
<div>
    <a class="matchview-navigLink" href="/?r=protocol/view&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>" target="_blank">Протокол матча</a>
    <a class="matchview-navigLink" href="/?r=match/view&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">Общая информация</a>
</div>
<? include '_head.php'?>
<h2>Ход игры</h2>
<script type="text/javascript">
    var $amf = $amf || {};
    $amf.teamroster = {};
    $amf.team = {};
    $amf.team[<?=$answer['match']['team1']?>] = '<?=$answer['match']['t1name']?>';
    $amf.team[<?=$answer['match']['team2']?>] = '<?=$answer['match']['t2name']?>';
    $amf.teamroster[<?=$answer['match']['team1']?>] = <?print_r(json_encode($answer['team1roster']))?>;
    $amf.teamroster[<?=$answer['match']['team2']?>] = <?print_r(json_encode($answer['team2roster']))?>;
</script>
<?if (($_SESSION['userType'] >= 2) && ($_SESSION['userType'] <= 4)) {?>
    <div class="main-fieldWrapper">
        <button class="match-eventBtn main-btn roster-submit">Добавить событие</button>
    </div>
    <div class="match-eventWrapper main-hidden">
        <form method="post" action="/?r=match/createEvent">
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
    $action = NULL;
    $flag = false;
?>
<?for ($i = 0; $i < count($event); $i++) {?>
    <?$flag = true;?>
    <?if ($action != $event[$i]['id']) {
        $action = $event[$i]['id']?>
        <?if ($i > 0) {?>
            </div></div>
        <?}?>

        <div class="listview-item">
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
            <?}?>
            <?if($event[$i]['ch']){?>
            <div class="match-eventChar">
                <span><?=$event[$i]['ch']?></span>
                <span><?=$event[$i]['val']?></span>
            </div>
            <?}?>
<?}?>
<?if ($flag) {?>
</div></div>
<?}?>