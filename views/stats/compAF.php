<?
$arrRush1 = $answer['rush'];

$arrPass1 =$answer['pass'];

$arrQb1 = $answer['qb'];

?>
<h2>Статистика турнира</h2>
<table class="match_maintable">
    <tbody>
    <tr>
        <td>
            <h3 class="stats-header">Вынос</h3>
            <?$arr = $arrRush1; $head1 = 'ярдов'; $head2 = 'Попыток';?>
            <? include '_simpleAF2.php'?>

        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Прием</h3>
            <?$arr = $arrPass1; $head1 = 'ярдов'; $head2 = 'приемов';?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Пас</h3>
            <?$arr = $arrQb1;?>
            <? include '_qb2.php'?>
        </td>
    </tr>
    </tbody>
</table>


