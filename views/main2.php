<html>
<head>
    <title><?if ($title) { echo $title; }?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
    <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/fafr.css?19"/>
    <?if ($theme) {?>
        <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/<?=$theme?>/<?=$theme?>.css?23"/>
    <?}?>
    <link rel="shortcut icon" href="//<?=$HOST?>/themes/img/fafr_logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery-ui.css">
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery.Jcrop.min.css?1">
    <link href='http://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
</head>
<body class="fafr-body fafr-text">
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

<div class="fafr-wrapper fafr-minWidth">
    <div class="fafr-bg_dark fafr-minWidth">
        <div class="fafr-minWidth fafr-maxWidth">
            <a class="fafr-logo" href="/"></a>
            <div class="fafr-header">
                <h2 class="fafr-header_title fafr-h2"><?= $header ?></h2>
                <h4 class="fafr-header_title fafr-header_title_sub"><?= $subheader ?></h4>
                <div class="main-auth_form"><?php require ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/user/login.php');?></div>
                <div class="fafr-login" style="display: none"><?php require ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/user/loginPanel.php');?></div>
            </div>
        </div>
    </div>

    <div class="fafr-bg_accent fafr-minWidth">
        <div class="fafr-navigation fafr-minWidth fafr-maxWidth">
            <ul class="fafr-navigation__list">
                <? foreach ($NAVIGATION as $point) { ?>
                <li class="fafr-navigation__point">
                    <a class="fafr-navigation__link<?if ($point['id'] == $NAVCURRENT){?> fafr-bg_light<?}else{?> fafr-bg_accent<?}?>"
                       href="<?= $point['href'] ?>"><?= $point['title'] ?></a>
                </li>
                <? } ?>
            </ul>
        </div>
    </div>

    <?if (count($NAVIGATION2)) {?>
        <div class="fafr-bg_light fafr-minWidth">
            <div class="fafr-navigation fafr-minWidth fafr-maxWidth">
                <ul class="fafr-navigation__list">
                    <? foreach ($NAVIGATION2 as $point) { ?>
                    <li class="fafr-navigation__point">
                        <a class="fafr-navigation__link__second fafr-bg_light<?if ($point['id'] == $NAVCURRENT2){?> fafr-navigation__link__second__selected<?}?>"
                           href="<?= $point['href'] ?>"><?= $point['title'] ?></a>
                    </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    <?}?>
    <div class="fafr-content">
        <?php
            if (file_exists($content)) {
                require $content;
            }
        ?>
    </div>
    <div class="fafr-footerplace"></div>
</div>

<div class="fafr-footer_wrapper fafr-bg_dark fafr-minWidth">
    <div class="fafr-footer fafr-minWidth fafr-maxWidth">
        <?$perc = round (100 / count($FOOTER_NAV))?>
        <?for ($i = 0; $i < count($FOOTER_NAV); $i++) {?>
            <div class="fafr-footer_column" style="width:<?=$perc?>%;">
                <?for ($j = 0; $j < count($FOOTER_NAV[$i]); $j++) {?>
                <a class="fafr-footer_link<?if ($FOOTER_NAV[$i][$j]['main']) {?> fafr-footer_link_main<?}?>"
                   href="<?= $FOOTER_NAV[$i][$j]['href'] ?>"><?= $FOOTER_NAV[$i][$j]['title'] ?></a>
                <?}?>
            </div>
        <?}?>
        <div class="fafr-footer_img"></div>
    </div>
</div>

<script src="//<?=$HOST?>/jquery/jquery-1.10.2.js"></script>
<script src="//<?=$HOST?>/jquery/jquery-ui.js"></script>
<?if ( !($IS_MOBILE) ) {?>
    <script type="text/javascript" src="//<?=$HOST?>/jquery/ckeditor/ckeditor.js?2"></script>
    <script type="text/javascript" src="//<?=$HOST?>/jquery/ckeditor/adapters/jquery.js?2"></script>
<?}?>
<script src="//<?=$HOST?>/jquery/jquery.Jcrop.min.js?1"></script>

<script type="text/javascript" src="//<?=$HOST?>/themes/components.js?35"></script>
<?if (file_exists($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/' . $controller . '/' . $controller . '.js')) {?>
    <script type="text/javascript" src="//<?=$HOST?>/views/<?=$controller?>/<?=$controller?>.js?33"></script>
<?}?>

</body>
</html>