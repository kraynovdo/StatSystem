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
                <div class="stats-table_wrapper">
                    <?$arr = $arrRush1; $head1 = 'яр'; $head2 = 'поп'; $head3='тд'?>
                    <? include '_simpleAF.php'?>
                </div>

            </td>
            <td>
                <h3 class="stats-header">Вынос</h3>
                <div class="stats-table_wrapper">
                    <?$arr = $arrRush2;?>
                    <? include '_simpleAF.php'?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <h3 class="stats-header">Прием</h3>
                <div class="stats-table_wrapper">
                    <?$arr = $arrPass1; $head2 = 'пр';?>
                    <? include '_simpleAF.php'?>
                </div>
            </td>
            <td>
                <h3 class="stats-header">Прием</h3>
                <div class="stats-table_wrapper">
                    <?$arr = $arrPass2;?>
                    <? include '_simpleAF.php'?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <h3 class="stats-header">Пас</h3>
                <div class="stats-table_wrapper">
                    <?$arr = $arrQb1;?>
                    <? include '_qb.php'?>
                </div>
            </td>
            <td>
                <h3 class="stats-header">Пас</h3>
                <div class="stats-table_wrapper">
                    <?$arr = $arrQb2;?>
                    <? include '_qb.php'?>
                </div>
            </td>
        </tr>
        <tr>
            <td>

                <h3 class="stats-header">Перехваты</h3>
                <div class="stats-table_wrapper">
                    <?$arr = $arrInt1;?>
                    <? include '_int.php'?>
                </div>
            </td>
            <td>
                <h3 class="stats-header">Перехваты</h3>
                <div class="stats-table_wrapper">
                    <?$arr = $arrInt2;?>
                    <? include '_int.php'?>
                </div>
            </td>
        </tr>
    </tbody>
</table>


