<?$userfederation = $answer['userfederation'];?>
<?if (($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']] == 1)) {?>
    <a href="/?r=userfederation/add&federation=<?=$_GET['federation']?>&group=<?=$group?>" class="main-addLink">Добавить</a>
<?}?>
<?for ($i = 0; $i < count($userfederation); $i++) {?>
    <?if (($userfederation[$i]['work']) || ($_SESSION['userType'] == 3) || ($_SESSION['userFederations'][$_GET['federation']])) {?>
        <div class="federation-faceItem">
            <div class="federation-faceAvatar">
                <?if ($userfederation[$i]['avatar']) {?>
                    <img style="width:110px" src="//<?=$HOST?>/upload/<?=$userfederation[$i]['avatar']?>">
                <?} else {?>
                    <div class="main-noPhoto">?</div>
                <?}?>
            </div>
            <div class="federation-faceInfo">
                <div class="federation-faceFio">
                    <?=$userfederation[$i]['surname'] . ' ' . $userfederation[$i]['name'] . ' ' . $userfederation[$i]['patronymic']?>
                </div>
                <div class="federation-faceWork">
                    <?=$userfederation[$i]['work']?>
                </div>
                <div class="federation-faceEmail">
                    <a href="mailto:<?=$userfederation[$i]['email']?>"><?=$userfederation[$i]['email']?></a>
                </div>
                <?if ((($_SESSION['userType'] == 3)) || (($_SESSION['userFederations'][$_GET['federation']] == 1)) && $userfederation[$i]['person'] != $_SESSION['userPerson']) {?>
                    <a class="main-delLink" href="/?r=userfederation/delete&uf=<?=$userfederation[$i]['uf']?>&federation=<?=$_GET['federation']?>&group=<?=$group?>">[X]</a>
                <?}?>
            </div>

        </div>
    <?}?>
<?}?>