<?
$arrRush1 = $answer['rush'];
$arrPass1 =$answer['pass'];
$arrQb1 = $answer['qb'];
$arrRet1 = $answer['ret'];
$arrTac1 = $answer['tac'];
$arrSack1 = $answer['sack'];
$arrInt1 = $answer['int'];
$arrFg1 = $answer['fg'];
?>
<h2 class="stats-navHeader">Статистика турнира<?if (!$_GET['type']){?> - топ 5<?}?></h2>
<?if ($_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>">Вернуться к топ 5</a><?}?>
<table class="stats_maintable">
    <tbody>
    <?if (count($arrQb1)) {?>
    <tr>
        <td>
            <h3 class="stats-header stats-navHeader">Пас</h3>
            <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=qb">Полный список</a><?}?>
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
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <?}?>
    <?if (count($arrRush1)) {?>
    <tr>
        <td>
            <h3 class="stats-header stats-navHeader">Вынос</h3>
            <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=rush">Полный список</a><?}?>
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
            )?>
            <? include '_simpleAF2.php'?>

        </td>
    </tr>
    <?}?>
    <?if (count($arrPass1)) {?>
    <tr>
        <td>
            <h3 class="stats-header stats-navHeader">Прием</h3>
            <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=pass">Полный список</a><?}?>
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
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <?}?>
    <?if (count($arrInt1)) {?>
    <tr>
        <td>
            <h3 class="stats-header stats-navHeader">Перехваты</h3>
            <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=int">Полный список</a><?}?>
            <?$arr = $arrInt1; $columns = array(
                array(
                    'title' => 'кол',
                    'field' => 'cnt'
                )
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <?}?>
    <?if (count($arrSack1)) {?>
        <tr>
            <td>
                <h3 class="stats-header stats-navHeader">Сэки</h3>
                <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=sack">Полный список</a><?}?>
                <?$arr = $arrSack1; $columns = array(
                    array(
                        'title' => 'сол',
                        'field' => 'solo'
                    ),
                    array(
                        'title' => 'асс',
                        'field' => 'assist'
                    )
                )?>
                <? include '_simpleAF2.php'?>
            </td>
        </tr>
    <?}?>
    <?if (count($arrTac1)) {?>
    <tr>
        <td>
            <h3 class="stats-header stats-navHeader">Захваты</h3>
            <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=tac">Полный список</a><?}?>
            <?$arr = $arrTac1; $columns = array(
                array(
                    'title' => 'сол',
                    'field' => 'solo'
                ),
                array(
                    'title' => 'асс',
                    'field' => 'assist'
                )
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <?}?>
    <?if (count($arrRet1)) {?>
    <tr>
        <td>
            <h3 class="stats-header stats-navHeader">Возврат</h3>
            <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=ret">Полный список</a><?}?>
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
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <?}?>
    <?if (count($arrFg1)) {?>
    <tr>
        <td>
            <h3 class="stats-header stats-navHeader">Удары по воротам</h3>
            <?if (!$_GET['type']) {?><a href="/?r=stats/compAF&comp=<?=$_GET['comp']?>&type=fg">Полный список</a><?}?>
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
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <?}?>
    </tbody>
</table>


