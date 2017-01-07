<div class="main-wrapper">
    <div class="main-min-width">
        <div class="main-header">
            <a class="main-logo" href="/">
                <img class="main-logo_img" src="//<?= $HOST ?>/<?= $logo ?>?1">
            </a>

            <h1 class="main-header_title"><?= $header ?></h1>

            <div class="main-auth_form"><?php require ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/user/login.php');?></div>
        </div>
        <div class="main-topNavigation">
            <ul class="main-topNavigation__list">
                <? foreach ($NAVIGATION as $point => $href) { ?>
                    <li class="main-topNavigation__point list-unstyled">
                        <a class="main-topNavigation__link<?if ($point == $NAVCURRENT){?> main-topNavigation__link__selected<?}?>"
                         href="<?= $href ?>"><?= $point ?></a></li>
                <? } ?>
            </ul>
        </div>

        <div class="main-lvl3Navigation">
            <ul class="main-lvl3Navigation__list">
                <? foreach ($NAVIGATION3 as $point => $href) { ?>
                    <li class="main-lvl3Navigation__point list-unstyled">
                        <a class="main-lvl3Navigation__link<?if ($point == $NAVCURRENT3){?> main-lvl3Navigation__link__selected<?}?>"
                           href="<?= $href ?>"><?= $point ?></a></li>
                <? } ?>
            </ul>
        </div>

        <div class="main-middle row">
            <div class="col-lg-9 col-md-9">
                <div class="main-content">
                    <?php
                    if (file_exists($content)) {
                        require $content;
                    }
                    ?>
                </div>
            </div>
            <div class="main-aside col-lg-3 col-md-3">
                <?if ($NAVIGATION2 && count($NAVIGATION2)) {?>
                    <div class="main-lvl2Navigation">
                        <ul class="main-lvl2NavigationList">
                            <? foreach ($NAVIGATION2 as $point => $href) { ?>
                                <li class="main-lvl2Navigation__point list-unstyled">
                                    <a class="main-lvl2Navigation__link<?if ($point == $NAVCURRENT2){?> main-lvl2Navigation__link__selected<?}?>"
                                       href="<?= $href ?>"><?= $point ?></a></li>
                            <? } ?>
                        </ul>
                    </div>
                <?}?>
            </div>
        </div>
        <div class="main-content-space"></div>
    </div>
</div>
<div class="main-footer">
    <div class="main-footerHelmet"></div>
    <div class="main-min-width">
        <a class="main-logo" href="/">
            <img class="main-logo_img" src="//<?= $HOST ?>/<?= $logo ?>?1">
        </a>

        <h1 class="main-header_title"><?= $header ?></h1>
    </div>
</div>
