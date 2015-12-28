<html>
    <head>
        <link rel="shortcut icon" href="//<?=$HOST?>/themes/img/fafr_logo.png" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="//<?=$HOST?>/themes/print.css?<?=time();?>"/>
    </head>
    <body>
    <?php
        if (file_exists($content)) {
            require $content;
        }
    ?>
    </body>
</html>
