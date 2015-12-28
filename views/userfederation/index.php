<h2>Официальные лица</h2>
<?if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
    <a href="/?r=userfederation/add&federation=<?=$_GET['federation']?>" class="main-addLink">Добавить</a>
<?}?>
<?for ($i = 0; $i < count($answer); $i++) {?>
    <?if (($answer[$i]['work']) || ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']])) {?>
        <div class="listview-item<?if (!$answer[$i]['work']){?> federation-itemUser<?}?>">
            <span class="federation-itemWork">
                <?=$answer[$i]['work']?> -
            </span>
            <?=$answer[$i]['surname'] . ' ' . $answer[$i]['name'] . ' ' . $answer[$i]['patronymic']?>
<?
    $contArr = array();
    if ($answer[$i]['phone']) {
        array_push($contArr, 'тел: '.$answer[$i]['phone']);
    }
    if ($answer[$i]['email']) {
        array_push($contArr, 'e-mail: '.$answer[$i]['email']);
    }
?>
            (<?=implode($contArr, ', ')?>)
            <?if ((($_SESSION['userType'] == 3)) || (($_SESSION['userFederations'][$_GET['federation']] == 1)) && $answer[$i]['person'] != $_SESSION['userPerson']) {?>
                <a class="main-delLink" href="/?r=userfederation/delete&uf=<?=$answer[$i]['uf']?>&federation=<?=$_GET['federation']?>">[X]</a>
            <?}?>
        </div>
    <?}?>
<?}?>