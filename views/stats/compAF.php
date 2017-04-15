<?
$arrRush1 = $answer['rush'];

$arrPass1 =$answer['pass'];

$arrQb1 = $answer['qb'];

$arrTackle = $answer['tackle'];
?>
<h2>Статистика турнира</h2>
<table class="match_maintable">
    <tbody>
    <tr>
        <td>
            <h3 class="stats-header">Вынос</h3>
            <?$arr = $arrRush1; $head1 = 'ярдов'; $head2 = 'Попыток'; $field1='sumr'; $field2='num';?>
            <? include '_simpleAF2.php'?>

        </td>
    </tr>
    <tr>
        <td>
            <h3 class="stats-header">Прием</h3>
            <?$arr = $arrPass1; $head1 = 'ярдов'; $head2 = 'приемов'; $field1='sumr'; $field2='num';?>
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
    <tr>
        <td>
            <h3 class="stats-header">Захваты</h3>
            <?$arr = $arrTackle; $head1 = 'соло'; $head2 = 'ассист'; $field1='solo'; $field2='assist';?>
            <? include '_simpleAF2.php'?>
        </td>
    </tr>
    </tbody>
</table>


