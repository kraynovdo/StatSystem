<div class="main-wrapper">
    <div class="main-auth main-wrapper_allWidth">
        <div class="main-auth_form"><?php require ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/user/login.php');?></div>
    </div>
    <div class="main-header main-wrapper_allWidth">
        <!--<div class="main-topNavigation">
            <ul class="main-topNavigation__list">
                <?foreach($navigation as $point => $href) {?>
                    <li class="main-topNavigation__point"><a class="main-topNavigation__link" href="<?=$href?>"><?=$point?></a></li>
                <?}?>
            </ul>
        </div>-->
        <h1 class="main-header_title"><?=$header?></h1>
    </div>

    <div class="main-content">
        <?php
        if (file_exists($content)) {
            require $content;
        }
        ?>
    </div>
    <div class="main-bottom"></div>
    <div class="main-overlay main-hidden"></div>
    <div class="main-navbar">
        <a class="main-logo" href="/">
            <img class="main-logo_img" src="//<?=$HOST?>/<?=$logo?>?1">
        </a>
        <a class="main-navShowPanel" href="javascript: void(0)"></a>
    </div>
    <div class="main-navigation main-hidden">
        <ul class="main-topNavigation__list">
            <?foreach($navigation as $point => $href) {?>
                <li class="main-navigation__point"><a class="main-navigation__link" href="<?=$href?>"><?=$point?></a></li>
            <?}?>
        </ul>
    </div>
</div>