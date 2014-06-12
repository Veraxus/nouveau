<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php \NV\Theme::page_title(); ?></title>
  
    <!--wp_head-->
    <?php wp_head(); //Enqueue your own stuff in functions.php or \NV\Hooks\Config::enqueue_assets() ?>
    <!--/wp_head-->

    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
    <script>
        jQuery(function(){
            CFInstall.check({
                mode: "overlay",
                node: "prompt"
            });
        });
    </script>
    <![endif]-->

    <!-- Font embed code goes here -->

</head>
<body <?php body_class() ?>>
    <div id="frame">