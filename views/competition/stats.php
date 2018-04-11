<?
$arrRush1 = $answer['rush'];
$arrPass1 =$answer['pass'];
$arrQb1 = $answer['qb'];
$arrRet1 = $answer['ret'];
$arrTac1 = $answer['tac'];
$arrSack1 = $answer['sack'];
$arrInt1 = $answer['int'];
$arrFg1 = $answer['fg'];
if ($_GET['type']) {
    $p_page = $_GET['page'];
    if (!$p_page) {
        $p_page = 1;
    }
    $p_limit = 40;
}
$p_ret = 'competition/stats';
?>
<?if ($_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>">Вернуться к топ 5</a><?}?>
<table class="stats_maintable fafr-text">
<tbody>
<?if (count($arrQb1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=qb">Полный список</a><?}?>
        <h2 class="fafr-h2  stats-navHeader">Пас</h2>
        <?$arr = $arrQb1; $columns = array(
        array(
            'title' => 'рей',
            'field' => 'rate'
        ),
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
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>
    </td>
</tr>
    <?}?>
<?if (count($arrRush1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=rush">Полный список</a><?}?>
        <h2 class="fafr-h2  stats-navHeader">Вынос</h2>
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
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>

    </td>
</tr>
    <?}?>
<?if (count($arrPass1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=pass">Полный список</a><?}?>
        <h2 class="fafr-h2  stats-navHeader">Прием</h2>
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
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>
    </td>
</tr>
    <?}?>
<?if (count($arrInt1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=int">Полный список</a><?}?>
        <h2 class="fafr-h2  stats-navHeader">Перехваты</h2>
        <?$arr = $arrInt1; $columns = array(
        array(
            'title' => 'кол',
            'field' => 'cnt'
        )
    )?>
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>
    </td>
</tr>
    <?}?>
<?if (count($arrSack1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=sack">Полный список</a><?}?>
        <h2 class="fafr-h2  stats-navHeader">Сэки</h2>
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
    )?>
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>
    </td>
</tr>
    <?}?>
<?if (count($arrTac1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=tac">Полный список</a><?}?>
        <h2 class="fafr-h2  stats-navHeader">Захваты</h2>
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
        )?>
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>
    </td>
</tr>
    <?}?>
<?if (count($arrRet1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=ret">Полный список</a><?}?>
        <h2 class="fafr-h2  stats-navHeader">Возврат</h2>
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
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>
    </td>
</tr>
    <?}?>
<?if (count($arrFg1)) {?>
<tr>
    <td>
        <?if (!$_GET['type']) {?><a class="fafr-link stats-fullListLink" href="/?r=competition/stats&comp=<?=$_GET['comp']?>&type=fg">Полный список</a><?}?>
        <h2 class="fafr-h2 stats-navHeader">Удары по воротам</h2>
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
        <? include($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/stats/_simpleAF2.php')?>
    </td>
</tr>
    <?}?>
</tbody>
</table>


