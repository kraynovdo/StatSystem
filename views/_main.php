
<div class="main-top-fixed">
    <div class="main-auth">
        <div class="main-min-width">
            <div class="main-auth_form"><?php require ($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/views/user/login.php');?></div>
        </div>
    </div>
    <div class="main-header">
        <div class="main-min-width main-header_mw">
            <a class="main-logo" href="/">
                <img class="main-logo_img" src="//<?= $HOST ?>/<?= $logo ?>?1">
            </a>

            <h1 class="main-header_title"><?= $header ?></h1>


        </div>
    </div>

    <div class="main-topNavigation">
        <div class="main-min-width">
            <ul class="main-topNavigation__list">
                <? foreach ($navigation as $point => $href) { ?>
                    <li class="main-topNavigation__point"><a class="main-topNavigation__link"
                                                             href="<?= $href ?>"><?= $point ?></a></li>
                <? } ?>
            </ul>
        </div>
    </div>
</div>
<div class="main-min-width main-contentShadow">
    <div class="main-content">

        <?php
        if (file_exists($content)) {
            require $content;
        }
        ?>
    </div>
</div>
<div class="main-bottom"></div>
