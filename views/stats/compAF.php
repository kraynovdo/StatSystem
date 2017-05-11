<?
$arrRush1 = $answer['rush'];

$arrPass1 =$answer['pass'];

$arrQb1 = $answer['qb'];

$arrTac1 = $answer['tackle'];
?>
<h2>Статистика турнира</h2>
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
    </tbody>
</table>


