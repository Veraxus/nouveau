<?php
/**
 * DEFAULT TEMPLATE
 *
 * This is the global default template. If WordPress can't find a more appropriate, specific template file,
 * it will use this one.
 */
\NV\Theme::get_header();
\NV\Theme::output_file_marker(__FILE__);
?>
    <div id="container" class="row">
        <div id="content" class="small-12 large-8 columns">
            <?php \NV\Theme::loop( 'parts/article', 'parts/article-empty' ); ?>
        </div>
    </div>
    <div id="sidebar" class="small-12 large-4 columns">
        <?php dynamic_sidebar('sidebar-1') ?>
    </div>
<?php
\NV\Theme::get_footer();