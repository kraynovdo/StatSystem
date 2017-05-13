<?
$arrRush1 = $answer['rush'];
$arrPass1 =$answer['pass'];
$arrQb1 = $answer['qb'];
$arrRet1 = $answer['ret'];
$arrTac1 = $answer['tackle'];
$arrInt1 = $answer['int'];
$arrFg1 = $answer['fg'];
?>
<h2>Статистика турнира - топ 5</h2>
<table class="match_maintable">
    <tbody>
    <tr>
        <td>
            <h3 class="stats-header">Пас</h3>
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
                ),
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Вынос</h3>
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
                    'title' => 'тд',
                    'field' => 'td'
                ),
            )?>
            <? include '_simpleAF2.php'?>

        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Прием</h3>
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
                    'title' => 'тд',
                    'field' => 'td'
                ),
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Перехваты</h3>
            <?$arr = $arrInt1; $columns = array(
                array(
                    'title' => 'кол',
                    'field' => 'cnt'
                )
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Захваты</h3>
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
    <tr>
        <td>
            <h3 class="stats-header">Возврат</h3>
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
            )?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Удары по воротам</h3>
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
    </tbody>
</table>


