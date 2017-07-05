<?
if ($answer['stats'] && count($answer['stats'])) {
    $arrRush1 = $answer['stats']['rush'];
    $arrPass1 =$answer['stats']['pass'];
    $arrQb1 = $answer['stats']['qb'];
    $arrRet1 = $answer['stats']['ret'];
    $arrTac1 = $answer['stats']['tac'];
    $arrSack1 = $answer['stats']['sack'];
    $arrInt1 = $answer['stats']['int'];
    $arrFg1 = $answer['stats']['fg'];
}
else {
    $arrRush1 = array();
    $arrPass1 = array();
    $arrQb1 = array();
    $arrRet1 = array();
    $arrTac1 = array();
    $arrSack1 = array();
    $arrInt1 = array();
    $arrFg1 = array();
}
?>
<h2>Статистика</h2>
<?if (count($answer['comps'])) {?>
<div class="main-fieldWrapper">
    <label>Турнир</label>
    <select class="team-compSelector">
        <?for ($i = 0; $i < count($answer['comps']); $i++) {?>
        <option value="<?=$answer['comps'][$i]['id']?>"
            <?if ($answer['comps'][$i]['id'] == $answer['compId']) {?> selected="selected"<?}?>><?=$answer['comps'][$i]['name']?> <?=$answer['comps'][$i]['yearB']?></option>
        <?}?>
    </select>
</div>
<?}?>
<table class="stats_maintable">
<tbody>
<?if (count($arrQb1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Пас</h3>
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
    );$sum = array('sumr', 'td', 'inter')?>
        <? include '_simpleAF.php'?>
    </td>
</tr>
    <?}?>
<?if (count($arrRush1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Вынос</h3>
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
        <? include '_simpleAF.php'?>

    </td>
</tr>
    <?}?>
<?if (count($arrPass1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Прием</h3>
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
        <? include '_simpleAF.php'?>
    </td>
</tr>
    <?}?>
<?if (count($arrInt1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Перехваты</h3>
        <?$arr = $arrInt1; $columns = array(
        array(
            'title' => 'кол',
            'field' => 'cnt'
        )
    );$sum = array('cnt');?>
        <? include '_simpleAF.php'?>
    </td>
</tr>
    <?}?>
<?if (count($arrSack1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Сэки</h3>
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
    );$sum = array('common');?>
        <? include '_simpleAF.php'?>
    </td>
</tr>
    <?}?>
<?if (count($arrTac1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Захваты</h3>
        <?$arr = $arrTac1;
        $columns = array(
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
        );  $sum = array('common');?>
        <? include '_simpleAF.php'?>
    </td>
</tr>
    <?}?>
<?if (count($arrRet1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Возврат</h3>
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
    );  $sum = array('sumr', 'num', 'td', '2pt');?>
        <? include '_simpleAF.php'?>
    </td>
</tr>
    <?}?>
<?if (count($arrFg1)) {?>
<tr>
    <td>
        <h3 class="stats-header stats-navHeader">Удары по воротам</h3>
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
    );  $sum = array('numr', 'fg', 'pt');?>
        <? include '_simpleAF.php'?>
    </td>
</tr>
    <?}?>
</tbody>
</table>
