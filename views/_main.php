<div class="main-wrapper">
    <div class="main-auth">
        <div class="main-auth_form"><?php require ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/user/login.php');?></div>
    </div>
    <div class="main-header">
        <a class="main-logo" href="/">
            <img class="main-logo_img" src="//<?=$HOST?>/<?=$logo?>?1">
        </a>
        <h1 class="main-header_title"><?=$header?></h1>
        <div class="main-topNavigation">
            <ul class="main-topNavigation__list">
                <?foreach($navigation as $point => $href) {?>
                    <li class="main-topNavigation__point"><a class="main-topNavigation__link" href="<?=$href?>"><?=$point?></a></li>
                <?}?>
            </ul>
        </div>

    </div>
    <div class="main-headerSpace"></div>
    <div class="main-content">
        <?php
        if (file_exists($content)) {
            require $content;
        }
        ?>
    </div>
    <div class="main-bottom"></div>
</div>