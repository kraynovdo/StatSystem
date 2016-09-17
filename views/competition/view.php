<div class="main-infoBlock main-infoBlock_results">

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
?>
    <a target="_blank" class="comp-resultsTable_match" href="/?r=match/view&match=<?=$res[$i]['id']?>&comp=<?=$_GET['comp']?>">
        <div class="comp-resultsTable_datetime">
            <?=common_dateFromSQL($res[$i]['date'])?>
            <?if (strlen($res[$i]['timeh']) && strlen($res[$i]['timeh'])) {?>
                <?=$res[$i]['timeh']?>:<?=$res[$i]['timem']?> (мск.)
            <?}?>
        </div>
        <div class="comp-resultsTable_row">
            <div class="comp-resultsTable_score"><?=$score1?></div>
            <?if (($res[$i]['t1abbr'])&& ($IS_MOBILE)) {?>
                <div class="comp-resultsTable_team comp-resultsTable_team_big"><?=$res[$i]['t1abbr']?></div>
            <?} else {?>
                <div class="comp-resultsTable_team"><?=$res[$i]['t1name']?></div>
            <?}?>
        </div>
        <div class="comp-resultsTable_row">
            <div class="comp-resultsTable_score"><?=$score2?></div>
            <?if (($res[$i]['t2abbr']) && ($IS_MOBILE)) {?>
                <div class="comp-resultsTable_team comp-resultsTable_team_big"><?=$res[$i]['t2abbr']?></div>
            <?} else {?>
                <div class="comp-resultsTable_team"><?=$res[$i]['t2name']?></div>
            <?}?>
        </div>
    </a>
<?}?>

        </div>
        <?if($_GET['comp'] == 18){?><h2><a href="/?r=standings">Сетка плей-офф</a></h2><?}?>
    </div>
    <br/>
    <div style="text-align:center">
        <?if ($_SESSION['userType'] == 3) {?>
        <a href="/?r=translation/edit&comp=<?=$_GET['comp']?>">Добавить трансляцию</a>
        <?}?>
<?
    $trans = $answer['trans'];
    if (count($trans)) {?>
        <h1>Трансляции online</h1>
        <?
            for ($i = 0; $i < count($trans); $i++) {?>
            <h2><?=$trans[$i]['title']?></h2>
                <?if ($_SESSION['userType'] == 3){?>
                    <div style="text-align: right">
                        <a href="/?r=translation/edit&trans=<?=$trans[$i]['id']?>&comp=<?=$_GET['comp']?>">Ред</a>
                        <a class="main-delLink" href="/?r=translation/delete&trans=<?=$trans[$i]['id']?>&comp=<?=$_GET['comp']?>">[x]</a>
                    </div>
                <?}?>
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
<tr>
<?if (count($answer['top10'])) {?>
<td style="vertical-align:top; padding: 4px" <?if (!count($answer['top10kick'])) {?> colspan="2"<?}?>>
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
            <a class="top10-item_logo top10-item_img" target="_blank" href="//<?=$HOST?>/?r=team/view&team=<?=$top[$i]['team']?>&comp=<?=$_GET['comp']?>">
                <?if ($top[$i]['logo']) {?>
                    <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['logo']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </a>
        </div>
    <?}?>
    </div>
	</td>
	<?}?>
	<?if (count($answer['top10kick'])) {?>
	<td style="vertical-align:top; padding: 4px">
	<?$top = $answer['top10kick'];?>
    <div class="main-card">
	<h2 style="text-align: center;">ТОП кикеров по очкам</h2>

    <?for ($i = 0; $i < count($top) ; $i++) {?>
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
            <a class="top10-item_logo top10-item_img" target="_blank" href="//<?=$HOST?>/?r=team/view&team=<?=$top[$i]['team']?>&comp=<?=$_GET['comp']?>">
                <?if ($top[$i]['logo']) {?>
                    <img style="width:50px" src="//<?=$HOST?>/upload/<?=$top[$i]['logo']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </a>
        </div>
    <?}?>
    </div>
</td>
<?}?>
</tr>
</table>



    </div>