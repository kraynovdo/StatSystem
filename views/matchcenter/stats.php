<?include '_head.php'?>
<?
$arrRush1 = array();
$arrRush2 = array();
for ($i = 0; $i < count($answer['rush']); $i++) {
    if ($answer['rush'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrRush1, $answer['rush'][$i]);
    }
    else {
        array_push($arrRush2, $answer['rush'][$i]);
    }
}
$arrRet1 = array();
$arrRet2 = array();
for ($i = 0; $i < count($answer['return']); $i++) {
    if ($answer['return'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrRet1, $answer['return'][$i]);
    }
    else {
        array_push($arrRet2, $answer['return'][$i]);
    }
}
$arrPass1 = array();
$arrPass2 = array();
for ($i = 0; $i < count($answer['pass']); $i++) {
    if ($answer['pass'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrPass1, $answer['pass'][$i]);
    }
    else {
        array_push($arrPass2, $answer['pass'][$i]);
    }
}
$arrQb1 = array();
$arrQb2 = array();
for ($i = 0; $i < count($answer['qb']); $i++) {
    if ($answer['qb'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrQb1, $answer['qb'][$i]);
    }
    else {
        array_push($arrQb2, $answer['qb'][$i]);
    }
}

$arrInt1 = array();
$arrInt2 = array();
for ($i = 0; $i < count($answer['int']); $i++) {
    if ($answer['int'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrInt1, $answer['int'][$i]);
    }
    else {
        array_push($arrInt2, $answer['int'][$i]);
    }
}
$arrTac1 = array();
$arrTac2 = array();
for ($i = 0; $i < count($answer['tac']); $i++) {
    if ($answer['tac'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrTac1, $answer['tac'][$i]);
    }
    else {
        array_push($arrTac2, $answer['tac'][$i]);
    }
}

$arrSack1 = array();
$arrSack2 = array();
for ($i = 0; $i < count($answer['sack']); $i++) {
    if ($answer['sack'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrSack1, $answer['sack'][$i]);
    }
    else {
        array_push($arrSack2, $answer['sack'][$i]);
    }
}
$arrFg1 = array();
$arrFg2 = array();
for ($i = 0; $i < count($answer['fg']); $i++) {
    if ($answer['fg'][$i]['team'] == $answer['match']['team1']) {
        array_push($arrFg1, $answer['fg'][$i]);
    }
    else {
        array_push($arrFg2, $answer['fg'][$i]);
    }
}
?>

<div class="fafr-minWidth fafr-maxWidth">
    <table class="match_maintable stats-match_maintable match-table">
    <colgroup>
        <col class="match-tableLeft fafr-topValigng" width="50%"/>
        <col class="match-tableRight fafr-topValigng" width="50%"/>
    </colgroup>
    <tbody>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrQb1)) {?>
            <h3 class="stats-header">Пас</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrQb1; $columns = array(
                array(
                    'title' => '%',
                    'field' => 'percent'
                ),
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => 'пер',
                    'field' => 'inter'
                )
            ); $sum = array('sumr', 'td', 'inter');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrQb2)) {?>
            <h3 class="stats-header">Пас</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrQb2; $columns = array(
                array(
                    'title' => '%',
                    'field' => 'percent'
                ),
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => 'пер',
                    'field' => 'inter'
                )
            ); $sum = array('sumr', 'td', 'inter');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrRush1)) {?>
            <h3 class="stats-header">Вынос</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrRush1; $columns = array(
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'поп',
                    'field' => 'num'
                ),
                array(
                    'title' => 'сред',
                    'field' => 'avg'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => '2оч',
                    'field' => '2pt'
                )
            );  $sum = array('sumr', 'num', 'td', '2pt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrRush2)) {?>
            <h3 class="stats-header">Вынос</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrRush2;$columns = array(
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'поп',
                    'field' => 'num'
                ),
                array(
                    'title' => 'сред',
                    'field' => 'avg'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => '2оч',
                    'field' => '2pt'
                )
            );  $sum = array('sumr', 'num', 'td', '2pt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrPass1)) {?>
            <h3 class="stats-header">Прием</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrPass1; $columns = array(
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'пр',
                    'field' => 'num'
                ),
                array(
                    'title' => 'сред',
                    'field' => 'avg'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => '2оч',
                    'field' => '2pt'
                )
            ); $sum = array('sumr', 'num', 'td', '2pt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrPass2)) {?>
            <h3 class="stats-header">Прием</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrPass2; $columns = array(
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'пр',
                    'field' => 'num'
                ),
                array(
                    'title' => 'сред',
                    'field' => 'avg'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => '2оч',
                    'field' => '2pt'
                )
            );   $sum = array('sumr', 'num', 'td', '2pt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrInt1)) {?>
            <h3 class="stats-header">Перехваты</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrInt1; $columns = array(
                array(
                    'title' => 'кол',
                    'field' => 'cnt'
                )
            ); $sum = array('cnt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrInt2)) {?>
            <h3 class="stats-header">Перехваты</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrInt2;$columns = array(
                array(
                    'title' => 'кол',
                    'field' => 'cnt'
                )
            ); $sum = array('cnt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrSack1)) {?>
            <h3 class="stats-header">Сэки</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrSack1; $columns = array(
                array(
                    'title' => 'общ',
                    'field' => 'common'
                ),
                array(
                    'title' => 'сол',
                    'field' => 'solo'
                ),
                array(
                    'title' => 'асс',
                    'field' => 'assist'
                )
            ); $sum = array();?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrSack2)) {?>
            <h3 class="stats-header">Сэки</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrSack2;$columns = array(
                array(
                    'title' => 'общ',
                    'field' => 'common'
                ),
                array(
                    'title' => 'сол',
                    'field' => 'solo'
                ),
                array(
                    'title' => 'асс',
                    'field' => 'assist'
                )
            ); $sum = array();?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrTac1)) {?>
            <h3 class="stats-header">Захваты</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrTac1; $columns = array(
                array(
                    'title' => 'общ',
                    'field' => 'common'
                ),
                array(
                    'title' => 'сол',
                    'field' => 'solo'
                ),
                array(
                    'title' => 'асс',
                    'field' => 'assist'
                )
            ); $sum = array('common');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrTac2)) {?>
            <h3 class="stats-header">Захваты</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrTac2; $columns = array(
                array(
                    'title' => 'общ',
                    'field' => 'common'
                ),
                array(
                    'title' => 'сол',
                    'field' => 'solo'
                ),
                array(
                    'title' => 'асс',
                    'field' => 'assist'
                )
            ); $sum = array('common');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrRet1)) {?>
            <h3 class="stats-header">Возврат</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrRet1; $columns = array(
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'поп',
                    'field' => 'num'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => '2оч',
                    'field' => '2pt'
                )
            );    $sum = array('sumr', 'num', 'td', '2pt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>

        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrRet2)) {?>
            <h3 class="stats-header">Возврат</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrRet2; $columns = array(
                array(
                    'title' => 'яр',
                    'field' => 'sumr'
                ),
                array(
                    'title' => 'поп',
                    'field' => 'num'
                ),
                array(
                    'title' => 'тд',
                    'field' => 'td'
                ),
                array(
                    'title' => '2оч',
                    'field' => '2pt'
                )
            );    $sum = array('sumr', 'num', 'td', '2pt');?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    <tr>
        <td class="match-tableLeft fafr-topValign">
            <?if (count($arrFg1)) {?>
            <h3 class="stats-header">Удары по воротам</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrFg1; $columns = array(
                array(
                    'title' => 'поп',
                    'field' => 'numr'
                ),
                array(
                    'title' => 'ФГ',
                    'field' => 'fg'
                ),
                array(
                    'title' => '1оч',
                    'field' => 'pt'
                )
            ); $sum = array();?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
        <td class="match-tableRight fafr-topValign">
            <?if (count($arrFg2)) {?>
            <h3 class="stats-header">Удары по воротам</h3>
            <div class="stats-table_wrapper">
                <?$arr = $arrFg2; $columns = array(
                array(
                    'title' => 'поп',
                    'field' => 'numr'
                ),
                array(
                    'title' => 'ФГ',
                    'field' => 'fg'
                ),
                array(
                    'title' => '1оч',
                    'field' => 'pt'
                )
            ); $sum = array();?>
                <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF.php');?>
            </div>
            <?}?>
        </td>
    </tr>
    </tbody>
    </table>
</div>