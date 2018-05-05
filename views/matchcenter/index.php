<?include '_head.php'?>
<div class="fafr-minWidth fafr-maxWidth">
    <?$action = $answer['action'];?>
    <table class="comp-point">
        <colgroup>
            <col width="45%"/>
            <col width="10%"/>
            <col width="45%"/>
        </colgroup>
        <tbody>
    <?for ($p1 = 0, $p2 = 0, $i = 0; $i < count($action); $i++){?>
        <?
            if ($action[$i]['team'] == $answer['maininfo']['team1']) {
                $p1 += $action[$i]['point'];
            }
            if ($action[$i]['team'] == $answer['maininfo']['team2']) {
                $p2 += $action[$i]['point'];
            }
        ?>
        <tr>
            <td class="fafr-topValign">
                <?if ($action[$i]['team'] == $answer['maininfo']['team1']) {?>
                    <div class="comp-point_action comp-point_action_left">
                        <span class="comp-point_abbr"><?=$action[$i]['abbr']?>: </span>
                        <span class="comp-point_fio"><?=trim($action[$i]['surname']. ' '.$action[$i]['name']);?></span>
                    </div>
                <?}?>
            </td>
            <td class="fafr-centerAl fafr-topValign">
                <div class="comp-point_count fafr-centerAl">
                    <span class="comp-point_digit fafr-centerAl"><?=$p1?></span>
                    <span class="comp-point_semicolon">:</span>
                    <span class="comp-point_digit fafr-centerAl"><?=$p2?></span>
                </div>
                <div class="comp-point_quarter fafr-textAdd">
                    <?if ($action[$i]['period'] < 5) {?>
                        <?=$action[$i]['period'] . ' четверть'?>
                    <?} else {?>
                        Овертайм
                    <?}?>
                </div>
            </td>
            <td class="fafr-topValign">
                <?if ($action[$i]['team'] == $answer['maininfo']['team2']) {?>
                    <div class="comp-point_action comp-point_action_right">
                        <span class="comp-point_abbr"><?=$action[$i]['abbr']?>: </span>
                        <span class="comp-point_fio"><?=trim($action[$i]['surname']. ' '.$action[$i]['name']);?></span>
                    </div>
                <?}?>
            </td>
        </tr>
    <?}?>
        </tbody>
    </table>
</div>