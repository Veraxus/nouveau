<?php
/**
 * Template Name: Foundation Test Page
 * 
 * This is an example override template. This can be selected from WordPress's "Edit Page" screens.
 * 
 * @package WordPress
 * @subpackage Nouveau
 * @since Nouveau 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Foundation 4</title>


    <link rel="stylesheet" href="<?php NV_CSS ?>/app.css" />


    <script src="<?php NV_JS ?>/custom.modernizr.min.js"></script>

</head>
<body>

<div class="row">
    <div class="large-12 columns">
        <h2>Welcome to Foundation</h2>
        <p>This is version 4.2.3.</p>
        <hr />
    </div>
</div>

<div class="row">
    <div class="large-8 columns">
        <h3>The Grid</h3>

        <!-- Grid Example -->
        <div class="row">
            <div class="large-12 columns">
                <div class="panel">
                    <p>This is a twelve column section in a row. Each of these includes a div.panel element so you can see where the columns are - it's not required at all for the grid.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns">
                <div class="panel">
                    <p>Six columns</p>
                </div>
            </div>
            <div class="large-6 columns">
                <div class="panel">
                    <p>Six columns</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="large-4 columns">
                <div class="panel">
                    <p>Four columns</p>
                </div>
            </div>
            <div class="large-4 columns">
                <div class="panel">
                    <p>Four columns</p>
                </div>
            </div>
            <div class="large-4 columns">
                <div class="panel">
                    <p>Four columns</p>
                </div>
            </div>
        </div>

        <h3>Buttons</h3>

        <div class="row">
            <div class="large-6 columns">
                <p><a href="#" class="small button">Small Button</a></p>
                <p><a href="#" class="button">Medium Button</a></p>
                <p><a href="#" class="large button">Large Button</a></p>
            </div>
            <div class="large-6 columns">
                <p><a href="#" class="small alert button">Small Alert Button</a></p>
                <p><a href="#" class="success button">Medium Success Button</a></p>
                <p><a href="#" class="large secondary button">Large Secondary Button</a></p>
            </div>
        </div>
    </div>

    <div class="large-4 columns">
        <h4>Getting Started</h4>
        <p>We're stoked you want to try Foundation! To get going, this file (index.html) includes some basic styles you can modify, play around with, or totally destroy to get going.</p>

        <h4>Other Resources</h4>
        <p>Once you've exhausted the fun in this document, you should check out:</p>
        <ul class="disc">
            <li><a href="http://foundation.zurb.com/docs">Foundation Documentation</a><br />Everything you need to know about using the framework.</li>
            <li><a href="http://github.com/zurb/foundation">Foundation on Github</a><br />Latest code, issue reports, feature requests and more.</li>
            <li><a href="http://twitter.com/foundationzurb">@foundationzurb</a><br />Ping us on Twitter if you have questions. If you build something with this we'd love to see it (and send you a totally boss sticker).</li>
        </ul>
    </div>
</div>

<script>
    document.write('<script src=' +
        ('__proto__' in {} ? '<?php NV_JS ?>/zepto' : '<?php NV_JS ?>/jquery') +
        '.min.js><\/script>')
</script>

<script src="<?php NV_JS ?>/foundation.js"></script>

<script src="<?php NV_JS ?>/foundation.alerts.js"></script>

<script src="<?php NV_JS ?>/foundation.clearing.js"></script>

<script src="<?php NV_JS ?>/foundation.cookie.js"></script>

<script src="<?php NV_JS ?>/foundation.dropdown.js"></script>

<script src="<?php NV_JS ?>/foundation.forms.js"></script>

<script src="<?php NV_JS ?>/foundation.interchange.js"></script>

<script src="<?php NV_JS ?>/foundation.joyride.js"></script>

<script src="<?php NV_JS ?>/foundation.magellan.js"></script>

<script src="<?php NV_JS ?>/foundation.orbit.js"></script>

<script src="<?php NV_JS ?>/foundation.placeholder.js"></script>

<script src="<?php NV_JS ?>/foundation.reveal.js"></script>

<script src="<?php NV_JS ?>/foundation.section.js"></script>

<script src="<?php NV_JS ?>/foundation.tooltips.js"></script>

<script src="<?php NV_JS ?>/foundation.topbar.js"></script>


<script>
    $(document).foundation();
</script>
</body>
</html>