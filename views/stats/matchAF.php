<? include ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/match/_head.php')?>
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
?>
<h2>Статистика матча</h2>
<table class="match_maintable">
    <colgroup>
        <col width="50%"/>
        <col width="50%"/>
    </colgroup>
    <tbody>
        <tr>
            <td>
                <h3 class="stats-header">Вынос</h3>
                <?$arr = $arrRush1; $head1 = 'ярдов'; $head2 = 'Попыток'; $head3='ТД'?>
                <? include '_simpleAF.php'?>

            </td>
            <td>
                <h3 class="stats-header">Вынос</h3>
                <?$arr = $arrRush2;?>
                <? include '_simpleAF.php'?>
            </td>
        </tr>
        <tr>
            <td>
                <h3 class="stats-header">Прием</h3>
                <?$arr = $arrPass1; $head2 = 'приемов';?>
                <? include '_simpleAF.php'?>
            </td>
            <td>
                <h3 class="stats-header">Прием</h3>
                <?$arr = $arrPass2;?>
                <? include '_simpleAF.php'?>
            </td>
        </tr>
        <tr>
            <td>
                <h3 class="stats-header">Пас</h3>
                <?$arr = $arrQb1;?>
                <? include '_qb.php'?>
            </td>
            <td>
                <h3 class="stats-header">Пас</h3>
                <?$arr = $arrQb2;?>
                <? include '_qb.php'?>
            </td>
        </tr>
    </tbody>
</table>


