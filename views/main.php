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
    <?}?>
    <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/main.css?30"/>
    <?if ($theme) {?>
        <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/<?=$theme?>/<?=$theme?>.css?6"/>
    <?}?>
    <link rel="shortcut icon" href="//<?=$HOST?>/themes/img/fafr_logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery-ui.css">
    <link rel="stylesheet" href="//<?=$HOST?>/jquery/jquery.Jcrop.min.css?1">
</head>
<body<?if($IS_MOBILE){?> class="main-body_mobile"<?}?>>
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
<script src="//<?=$HOST?>/jquery/jquery-1.10.2.js"></script>
<script src="//<?=$HOST?>/jquery/jquery-ui.js"></script>
<?if ( !($IS_MOBILE) ) {?>
    <script type="text/javascript" src="//<?=$HOST?>/jquery/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="//<?=$HOST?>/jquery/ckeditor/adapters/jquery.js"></script>
<?}?>
<script src="//<?=$HOST?>/jquery/jquery.Jcrop.min.js?1"></script>

<script type="text/javascript" src="//<?=$HOST?>/themes/components.js?16"></script>
<?if (file_exists($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/' . $controller . '/' . $controller . '.js')) {?>
    <script type="text/javascript" src="//<?=$HOST?>/views/<?=$controller?>/<?=$controller?>.js?14"></script>
<?}?>

</body>
</html>