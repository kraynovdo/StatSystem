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
    function yds($num) {
        if (!strlen($num)) {
            return '';
        }
        $ost100 = abs($num % 100);
        $ost10 = abs($num % 10);
        if ($ost100 >= 11 && $ost100 <= 14) {
            return 'ярдов';
        }
        if ($ost10 == 1) {
            return 'ярд';
        }
        if ($ost10 >= 2 && $ost10 <= 4) {
            return 'ярда';
        }
        return 'ярдов';
    }
?>
<?for ($i = 0; $i < count($event); $i++) {?>
<?

    $firstStr = ''; $secStr = '';
    $value = ''; $actStr = ''; $pg = 0;
    if ($event[$i]['action']) {
        if ($event[$i]['code'] == 'rush') {
            $value = common_twins($event[$i]['scvalue'], $event[$i]['sccode'], 'runyds');
            $man = common_twins($event[$i]['surname'], $event[$i]['spcode'], 'runner');
            $actStr = $man . ' ' . $value . ' ' . yds($value);
        } else if ($event[$i]['code'] == 'pass') {
            $value = common_twins($event[$i]['scvalue'], $event[$i]['sccode'], 'passyds');
            $man = common_twins($event[$i]['surname'], $event[$i]['spcode'], 'passer');
            $manRec = common_twins($event[$i]['surname'], $event[$i]['spcode'], 'receiver');
            $manInt = common_twins($event[$i]['surname'], $event[$i]['spcode'], 'intercept');

            print_r(array_search('receiver', array('passer')));
            if (!$manRec) {

                if ($manInt) {
                    $firstStr = 'Перехват';
                    $actStr = $man . ', перехватил - '.$manInt;
                }
                else {
                    $firstStr = 'Непринятый пас';
                    $actStr = $man;
                }
            }
            else {
                $actStr = $man . ', принял - '.$manRec;
            }
        } else {
            $firstStr = $event[$i]['action'];
            $actArr = array();
            if ($event[$i]['surname']) {
                array_push($actArr, $event[$i]['surname']);
            }
            if (strlen($event[$i]['scvalue'])) {
                array_push($actArr, $event[$i]['scvalue']. ' '.yds($event[$i]['scvalue']));
            }
            $actStr = implode(", ", $actArr);
        }
        if ($event[$i]['pg']) {
            $firstStr = $event[$i]['pg'];
            $secStr = $actStr;
            $pg = 1;
        }
        if (!$firstStr) {
            $firstStr = $event[$i]['action'] . ' ' . $value . ' ' . yds($value);
        }
        if (!$secStr) {
            $secStr = $actStr;
        }

    }

?>
        <div class="listview-item">
            <a class="main-delLink match-eventDelLink"
                href="/?r=match/deleteEvent&event=<?=$event[$i]['id']?>&match=<?=$_GET['match']?>&comp=<?=$_GET['comp']?>">[X]</a>
            <?if ($event[$i]['action']) {?>
                <div class="match-eventImgContainer">
                    <?if ($event[$i]['team']){?>
                        <img class="match-eventImg" src="//<?=$HOST?>/upload/<?=$event[$i]['team']?>"/>
                    <?}?>
                </div>
                <div class="match-eventMainInfo clearfix">
                    <div class="match-eventTitle<?if ($pg) {?> match-eventPG<?}?>"><?=$firstStr?></div>
                    <div class="match-eventAction"><?=$secStr?></div>
                </div>
            <?}?>
            <div class="match-eventComment"><?=$event[$i]['comment']?></div>
        </div>

<?}?>
