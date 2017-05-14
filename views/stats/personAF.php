<?
$arrRush1 = $stats['rush'];
$arrPass1 =$stats['pass'];
$arrQb1 = $stats['qb'];
$arrRet1 = $stats['ret'];
$arrTac1 = $stats['tac'];
$arrSack1 = $stats['sack'];
$arrInt1 = $stats['int'];
$arrFg1 = $stats['fg'];
?>
<?if ($_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>">Вернуться к топ 5</a><?}?>
<table class="stats_maintable">
    <tbody>
    <?if (count($arrQb1)) {?>
        <tr>
            <td>
                <?$statName = 'Пас'; $arr = array( 0 => $arrQb1); $columns = array(
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
                    ),
                )?>
                <? include '_simpleAF3.php'?>
            </td>
        </tr>
    <?}?>
    <?if (count($arrRush1)) {?>
        <tr>
            <td>
                <?$statName = 'Вынос'; $arr = array( 0 => $arrRush1); $columns = array(
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
                )?>
                <? include '_simpleAF3.php'?>

            </td>
        </tr>
    <?}?>
    <?if (count($arrPass1)) {?>
        <tr>
            <td>
                <?$statName = 'Прием'; $arr = array( 0 => $arrPass1); $columns = array(
                    array(
                        'title' => 'яр',
                        'field' => 'sumr'
                    ),
                    array(
                        'title' => 'пр',
                        'field' => 'num'
                    ),
                    array(
                        'title' => 'тд',
                        'field' => 'td'
                    ),
                )?>
                <? include '_simpleAF3.php'?>
            </td>
        </tr>
    <?}?>
    <?if (count($arrInt1)) {?>
        <tr>
            <td>
                <?$statName = 'Перехваты'; $arr = array( 0 => $arrInt1); $columns = array(
                    array(
                        'title' => 'кол',
                        'field' => 'cnt'
                    )
                )?>
                <? include '_simpleAF3.php'?>
            </td>
        </tr>
    <?}?>
    <?if (count($arrSack1)) {?>
        <tr>
            <td>
                <?$statName = 'Сэки'; $arr = array( 0 => $arrSack1); $columns = array(
                    array(
                        'title' => 'сол',
                        'field' => 'solo'
                    ),
                    array(
                        'title' => 'асс',
                        'field' => 'assist'
                    )
                )?>
                <? include '_simpleAF3.php'?>
            </td>
        </tr>
    <?}?>
    <?if (count($arrTac1)) {?>
        <tr>
            <td>
                <?$statName = 'Захваты'; $arr = array( 0 => $arrTac1); $columns = array(
                    array(
                        'title' => 'сол',
                        'field' => 'solo'
                    ),
                    array(
                        'title' => 'асс',
                        'field' => 'assist'
                    )
                )?>
                <? include '_simpleAF3.php'?>
            </td>
        </tr>
    <?}?>
    <?if (count($arrRet1)) {?>
        <tr>
            <td>
                <?$statName = 'Возврат'; $arr = array( 0 => $arrRet1); $columns = array(
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
                )?>
                <? include '_simpleAF3.php'?>
            </td>
        </tr>
    <?}?>
    <?if (count($arrFg1)) {?>
        <tr>
            <td>
                <?$statName = 'Удары по воротам'; $arr = array( 0 => $arrFg1); $columns = array(
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
                )?>
                <? include '_simpleAF3.php'?>
            </td>
        </tr>
    <?}?>
    </tbody>
</table>