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
    <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/main.css?150"/>
    <?if ($theme) {?>
        <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/<?=$theme?>/<?=$theme?>.css?50"/>
    <?}?>
    <?if ($IS_MOBILE) {?>
        <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/main_mobile_s.css?50"/>
    <?}?>
    <link rel="shortcut icon" href="//<?=$HOST?>/themes/img/fafr_logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery-ui.css">
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery.Jcrop.min.css?1">
    <script src="//<?=$HOST?>/jquery/jquery-1.10.2.js"></script>
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
<?if ( !($IS_MOBILE) ) {
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/_main.php');
}
else {
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/_mainMobile.php');
}?>
<?
    require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/views/YaMetrics.php');
?>
<script src="//<?=$HOST?>/jquery/jquery.cookie.js"></script>
<script src="//<?=$HOST?>/jquery/jquery-ui.js"></script>

<script src="//<?=$HOST?>/jquery/jquery.Jcrop.min.js?1"></script>

<script type="text/javascript" src="//<?=$HOST?>/themes/components.js?40"></script>
<?if (file_exists($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/' . $controller . '/' . $controller . '.js')) {?>
    <script type="text/javascript" src="//<?=$HOST?>/views/<?=$controller?>/<?=$controller?>.js?50"></script>
<?}?>

</body>
</html>