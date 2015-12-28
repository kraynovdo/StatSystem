<div class="main-infoBlock main-infoBlock_results">
<?if ($_GET['comp'] == 1) {?>
    <?
        function getMatchInfo($mid, $answer)
        {
            $matchInfo = array(
                'score1' => null,
                'score2' => null,
                'date' => null
            );
            $res = $answer['results'];
            for ($i = count($res) - 1; $i >= 0; $i--) {
                if ($res[$i]['id'] == $mid) {

                    if (!$res[$i]['score1'] && $res[$i]['score1'] != '0') {
                        $matchInfo['score1'] = '--';
                    } else {
                        $matchInfo['score1'] = $res[$i]['score1'];
                    }
                    if (!$res[$i]['score2'] && $res[$i]['score2'] != '0') {
                        $matchInfo['score2'] = '--';
                    } else {
                        $matchInfo['score2'] = $res[$i]['score2'];
                    }

                    $date_arr = explode('-', $res[$i]['date']);
                    $matchInfo['date'] = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
                    break;
                }
            }
            return $matchInfo;
        }
    ?>
    <h2 style="text-align: center">Плей-офф</h2>
    <table class=playoff-table>
        <colgroup>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
        </colgroup>


        <tr class="playoff-mainRow">
<?
    $match = 74;
    $info = getMatchInfo($match, $answer);
?>
            <td class="playoff-content">
                <a href="//champ2015.amfoot.ru/?r=match/view&match=<?=$match?>&comp=1" target="_blank">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>8.08.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/C55CD3D9-0684-422F-8F28-351139FE02A6.jpg">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/8B507AA8-D628-4E9F-A251-CACF224391D1.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>20<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>0<?}?></div>
                </a>
            </td>
            <td></td>
<?
    $match = 76;
    $info = getMatchInfo($match, $answer);
?>
            <td class="playoff-content">
                <a href="//champ2015.amfoot.ru/?r=match/view&match=<?=$match?>&comp=1">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>22.08.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/1BD31EC0-B232-4C3A-AAEB-F377D59AEF2C.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/C55CD3D9-0684-422F-8F28-351139FE02A6.jpg">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>24<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>0<?}?></div>
                </a>
            </td>
            <td></td>
<?
    $match = 83;
    $info = getMatchInfo($match, $answer);
?>
            <td class="playoff-content">
                <a href="//champ2015.amfoot.ru/?r=match/view&match=<?=$match?>&comp=1">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>6.09.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/1BD31EC0-B232-4C3A-AAEB-F377D59AEF2C.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/17964B8F-E599-45E4-B169-9D2D8B76EC1B.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>--<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>--<?}?></div>
                </a>
            </td>
            <td></td>
<?
    $match = 77;
    $info = getMatchInfo($match, $answer);
?>
            <td class="playoff-content">
                <a href="//champ2015.amfoot.ru/?r=match/view&match=<?=$match?>&comp=1">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>22.08.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/17964B8F-E599-45E4-B169-9D2D8B76EC1B.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/1B2B7F2E-E7C4-4F31-9DEC-3224948912F6.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>35<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>21<?}?></div>
                </a>
            </td>
            <td></td>
<?
    $match = 75;
    $info = getMatchInfo($match, $answer);
?>
            <td class="playoff-content">
                <a href="http://champ2015.amfoot.ru/?r=match/view&match=<?=$match?>&comp=1" target="_blank">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>9.08.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/1B2B7F2E-E7C4-4F31-9DEC-3224948912F6.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/4F4A8585-4B0F-4066-9251-0514C58A05C5.png">
                    </div>
                </a>
                <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>24<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>13<?}?></div>
            </td>
        </tr>

    </table>
    <br/>
<?}?>
<?if ($_GET['comp'] == 10) {?>
    <?
    function getMatchInfo($mid, $answer)
    {
        $matchInfo = array(
            'score1' => null,
            'score2' => null,
            'date' => null
        );
        $res = $answer['results'];
        for ($i = count($res) - 1; $i >= 0; $i--) {
            if ($res[$i]['id'] == $mid) {

                if (!$res[$i]['score1'] && $res[$i]['score1'] != '0') {
                    $matchInfo['score1'] = '--';
                } else {
                    $matchInfo['score1'] = $res[$i]['score1'];
                }
                if (!$res[$i]['score2'] && $res[$i]['score2'] != '0') {
                    $matchInfo['score2'] = '--';
                } else {
                    $matchInfo['score2'] = $res[$i]['score2'];
                }

                $date_arr = explode('-', $res[$i]['date']);
                $matchInfo['date'] = $date_arr[2] . '.' . $date_arr[1] . '.' . $date_arr[0];
                break;
            }
        }
        return $matchInfo;
    }
    ?>
    <p></p>
    <table class=playoff-table>
        <colgroup>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
            <col width="50px"/>
            <col width="160px"/>
        </colgroup>

        <tr class="playoff-mainRow">
            <?
            $match = 97;
            $info = getMatchInfo($match, $answer);
            ?>
            <td class="playoff-content">
                <a href="//cup2015.amfoot.ru/?r=match/view&match=<?=$match?>">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>26.09.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/08D99739-51E0-4BD1-A7D2-FCAF7E1DBD8B.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/5D7D4B2F-CF20-4F9E-A1C6-D17B4C73F213.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>3<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>22<?}?></div>
                </a>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <?
            $match = 92;
            $info = getMatchInfo($match, $answer);
            ?>
            <td class="playoff-content">
                <a href="//cup2015.amfoot.ru/?r=match/view&match=<?=$match?>">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>19.09.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/19E648BD-BA8F-4712-9187-8E738422FAF5.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/logo-Rebels-(только-кулак)2.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>22<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>19<?}?></div>
                </a>
            </td>
        </tr>
        <tr class="playoff-mainRow">
            <td></td>
            <td></td>
            <?
            $match = 100;
            $info = getMatchInfo($match, $answer);
            ?>
            <td class="playoff-content">
                <a href="//cup2015.amfoot.ru/?r=match/view&match=<?=$match?>">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>17.10.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/5D7D4B2F-CF20-4F9E-A1C6-D17B4C73F213.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/AE3B4491-881C-45F2-A63B-E5AC80BF707A.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>6<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>36<?}?></div>
                </a>
            </td>
            <td></td>
            <?
            $match = 102;
            $info = getMatchInfo($match, $answer);
            ?>
            <td class="playoff-content">
                <a href="//cup2015.amfoot.ru/?r=match/view&match=<?=$match?>">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>7.11.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/1D217ED1-85E2-4880-AD72-924E783771EA.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/AE3B4491-881C-45F2-A63B-E5AC80BF707A.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>3<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>43<?}?></div>
                </a>
            </td>
            <td></td>
            <?
            $match = 101;
            $info = getMatchInfo($match, $answer);
            ?>
            <td class="playoff-content">
                <a href="//cup2015.amfoot.ru/?r=match/view&match=<?=$match?>">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>24.10.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/19E648BD-BA8F-4712-9187-8E738422FAF5.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/1D217ED1-85E2-4880-AD72-924E783771EA.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>--<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>--<?}?></div>
                </a>
            </td>
            <td></td>

            <td>

            </td>
        </tr>
        <tr class="playoff-mainRow">
            <?
            $match = 98;
            $info = getMatchInfo($match, $answer);
            ?>
            <td class="playoff-content">
                <a href="//cup2015.amfoot.ru/?r=match/view&match=<?=$match?>">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>3.10.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/C55CD3D9-0684-422F-8F28-351139FE02A6.jpg">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/AE3B4491-881C-45F2-A63B-E5AC80BF707A.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>8<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>30<?}?></div>
                </a>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            <?
            $match = 99;
            $info = getMatchInfo($match, $answer);
            ?>
            <td class="playoff-content">
                <a href="//cup2015.amfoot.ru/?r=match/view&match=<?=$match?>">
                    <div class="playoff-text"><?if ($info['date']){?><?=$info['date']?><?}else{?>17.10.2015<?}?></div>
                    <div class="playoff-logos">
                        <img class="playoff-logo1" style="width:50px" src="//amfoot.ru/upload/033205B1-34B3-400E-981C-75D38A61C06E.png">
                        <img class="playoff-logo2" style="width:50px" src="//amfoot.ru/upload/1D217ED1-85E2-4880-AD72-924E783771EA.png">
                    </div>
                    <div class="playoff-text"><?if ($info['score1']){?><?=$info['score1']?><?}else{?>16<?}?>:<?if ($info['score2']){?><?=$info['score2']?><?}else{?>32<?}?></div>
                </a>
            </td>
        </tr>
    </table>
    <br/>
<?}?>
<?if ($_GET['comp'] != 1 && $_GET['comp'] != 10) {?>
    <br/><h2 style="text-align: center">Результаты матчей</h2>
    <div class="comp-resultsTable">
<?
    $res = $answer['results'];
    for ($i = count($res) - 1; $i >= 0 ; $i--) {
        if (!$res[$i]['score1'] && $res[$i]['score1'] != '0') {
            $score1 = '-';
        }
        else {
            $score1 = $res[$i]['score1'];
        }
        if (!$res[$i]['score2'] && $res[$i]['score2'] != '0') {
            $score2 = '-';
        }
        else {
            $score2 = $res[$i]['score2'];
        }

        $date_arr = explode('-', $res[$i]['date']);
        $date = $date_arr[2] . '.' . $date_arr[1];
?>
    <a target="_blank" class="comp-resultsTable_match" href="/?r=match/view&match=<?=$res[$i]['id']?>&comp=<?=$_GET['comp']?>">
        <div class="comp-resultsTable_team1">
            <div class="comp-resultsTable_score">
                <?=$score1?>
            </div>
            <div class="comp-resultsTable_team">
                <?=$res[$i]['t1name']?>
            </div>
        </div>
        <div class="comp-resultsTable_date"><?=$date?><br/></div>
        <div class="comp-resultsTable_team2">
            <div class="comp-resultsTable_score">
                <?=$score2?>
            </div>
            <div class="comp-resultsTable_team">
                <?=$res[$i]['t2name']?>
            </div>
        </div>
    </a>
<?}?>

        </div>
<?}?>
    </div>
    <br/>
    <div style="text-align:center">
<?
    $trans = $answer['trans'];
    if (count($trans)) {?>
        <h1>Трансляции online</h1>
        <?
            for ($i = 0; $i < count($trans); $i++) {?>
            <h2><?=$trans[$i]['title']?></h2>
                <?if ($_SESSION['userType'] == 3){?><div style="text-align: right"><a href="/?r=translation/edit&trans=<?=$trans[$i]['id']?>">Ред</a></div><?}?>
                <?
                    $link = $trans[$i]['link'];
                    $link = str_replace("\\\"", "\"", $link);
                    echo $link;

                ?><br/><br/>
        <?  }?>
<?  }?>

<table style="width: 100%;">
<colgroup>
	<col width="50%"/>
	<col width="50%"/>
</colgroup>
<tr><td style="vertical-align:top; padding: 4px">
<?$top = $answer['top10'];?>

    <div class="main-card">
    <?if (count($top)){?><h2 style="text-align: center;">ТОП по набранным очкам</h2><?}?>
    <?
    for ($i = 0; $i < count($top) ; $i++) {?>
        <div class="top10-item" style="width:400px">
            <a class="top10-item_avatar top10-item_img" target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>">
                <?if ($top[$i]['avatar']) {?>
                    <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['avatar']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </a>
            <div class="top10-item_content">
                <div class="top10-item_point top10-item_img"><?=$top[$i]['points']?></div>
                <a class="top10-item_fio"  target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>"><?=$top[$i]['surname'] . ' ' . $top[$i]['name']?></a>
            </div>
            <a class="top10-item_logo top10-item_img" target="_blank" href="/?r=team/view&team=<?=$top[$i]['team']?>">
                <?if ($top[$i]['logo']) {?>
                    <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['logo']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </a>
        </div>
    <?}?>
    </div>
	</td><td style="vertical-align:top; padding: 4px">
	<?$top = $answer['top10kick'];?>
    <div class="main-card">
	<?if (count($top)){?><h2 style="text-align: center;">ТОП кикеров по очкам</h2><?}?>

    <?

    for ($i = 0; $i < count($top) ; $i++) {?>
        <div class="top10-item" style="width:400px">
            <a class="top10-item_avatar top10-item_img" target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>">
                <?if ($top[$i]['avatar']) {?>
                    <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['avatar']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </a>
            <div class="top10-item_content">
                <div class="top10-item_point top10-item_img"><?=$top[$i]['points']?></div>
                <a class="top10-item_fio"  target="_blank" href="/?r=person/view&person=<?=$top[$i]['person']?>"><?=$top[$i]['surname'] . ' ' . $top[$i]['name']?></a>
            </div>
            <a class="top10-item_logo top10-item_img" target="_blank" href="/?r=team/view&team=<?=$top[$i]['team']?>">
                <?if ($top[$i]['logo']) {?>
                    <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['logo']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </a>
        </div>
    <?}?>
    </div>
</td></tr>
</table>



    </div>