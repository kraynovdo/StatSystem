<html>
<head>
    <title><?if ($title) { echo $title; }?></title>
    <?if ($description){?>
        <meta name="description" content="<?=$description?>">
    <?}?>
    <?if ($keywords){?>
        <meta name="keywords" content="<?=$keywords?>">
    <?}?>
    <?if ($IS_MOBILE) {?>
        <script type="text/javascript">window.mobile = true;</script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?}?>
    <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/main2.css?7"/>
    <link rel="shortcut icon" href="//<?=$HOST?>/themes/img/fafr_logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery-ui.css">
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery.Jcrop.min.css?1">
</head>
<body>
<? if ($_SESSION['error']){?>
    <div class="main-error">
        <?=$_SESSION['error']?>
    </div>
    <?
    $_SESSION['error'] = '';
}?>
<? if ($_SESSION['message']){?>
    <div class="main-message">
        <?=$_SESSION['message']?>
    </div>
    <?
    $_SESSION['message'] = '';
}?>
<div class="main-wrapper">
    <div class="main-min-width">
        <div class="main-header">
            <a class="main-logo" href="/">
                <img alt="Логотип" class="main-logo_img" src="//<?= $HOST ?>/<?= $logo ?>?1">
            </a>

            <h1 class="main-header_title"><?= $header ?></h1>

            <div class="main-auth_form"><?php require ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/user/login.php');?></div>
        </div>
        <div class="main-topNavigation">
            <ul class="main-topNavigation__list">
                <? foreach ($NAVIGATION as $point => $href) { ?>
                    <li class="main-topNavigation__point list-unstyled">
                        <a class="main-topNavigation__link<?if ($point == $NAVCURRENT){?> main-topNavigation__link__selected<?}?>"
                           href="<?= $href ?>"><?= $point ?></a>
                    </li>
                <? } ?>
            </ul>
        </div>

        <div class="main-lvl4Navigation">
            <?if (count($NAVIGATION4)) {?>
                <ul class="main-lvl4Navigation__list">
                    <? foreach ($NAVIGATION4 as $point => $href) { ?>
                        <li class="main-lvl4Navigation__point list-unstyled">
                            <a class="main-lvl4Navigation__link<?if ($point == $NAVCURRENT4){?> main-lvl4Navigation__link__selected<?}?>"
                               href="<?= $href ?>"><?= $point ?></a></li>
                    <? } ?>
                </ul>
            <?}?>
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
                                       href="<?= $href ?>"><?= $point ?></a>
                                    <?if (($point == $NAVCURRENT2) && count($NAVIGATION3)){?>
                                        <ul class="main-lvl3Navigation__list">
                                            <? foreach ($NAVIGATION3 as $point => $href) { ?>
                                                <li class="main-lvl3Navigation__point list-unstyled">
                                                    <a class="main-lvl3Navigation__link<?if ($point == $NAVCURRENT3){?> main-lvl3Navigation__link__selected<?}?>"
                                                       href="<?= $href ?>"><?= $point ?></a></li>
                                            <? } ?>
                                        </ul>
                                    <?}?>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                <?}?>
                <div class="main-banner main-documentsBanner">
                    <div class="main-banner_header">Официальные документы</div>
                    <a href="/?r=document&federation=11" class="main-banner_btn main-documentsBannerBtn">Просмотреть</a>
                </div>
                <?if (false && ($_SESSION['userTeams']) && (count($_SESSION['userTeams']) >= 1)){?>
                    <div class="main-banner">
                        <div class="main-banner_header">Заявка на участие в ЛАФ 2017</div>
                        <a href="/?r=request/choose&comp=64" class="main-banner_btn main-documentsBannerBtn">Подать заявку</a>
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

<script src="//<?=$HOST?>/jquery/jquery-1.10.2.js"></script>
<script src="//<?=$HOST?>/jquery/jquery-ui.js"></script>
<?if ( !($IS_MOBILE) ) {?>
    <script type="text/javascript" src="//<?=$HOST?>/jquery/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="//<?=$HOST?>/jquery/ckeditor/adapters/jquery.js"></script>
<?}?>
<script src="//<?=$HOST?>/jquery/jquery.Jcrop.min.js?1"></script>

<script type="text/javascript" src="//<?=$HOST?>/themes/components.js?34"></script>
<?if (file_exists($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/' . $controller . '/' . $controller . '.js')) {?>
    <script type="text/javascript" src="//<?=$HOST?>/views/<?=$controller?>/<?=$controller?>.js?32"></script>
<?}?>

</body>
</html>