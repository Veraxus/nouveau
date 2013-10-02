<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?php \NV\Theme::page_title(); ?></title>
  
    <!--wp_head-->
    <?php wp_head(); //Enqueue your own stuff in functions.php or \NV\Hooks\General::enqueue_assets() ?>
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


    <!-- Typekit embed code goes here -->


</head>
<body <?php body_class() ?>>
    <div id="frame">