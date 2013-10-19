<?php
/**
 * DEFAULT ARCHIVE TEMPLATE
 *
 * This is the default template for archive pages (pages that show multiple posts).
 */
\NV\Theme::get_header();
\NV\Theme::output_file_marker(__FILE__);
?>
    <div id="container" class="archive row">
        <div id="content" class="small-12 large-8 columns">
            <?php \NV\Theme::archive_nav(array('id' => 'nav-top')) ?>
            <?php \NV\Theme::loop( 'parts/article' , 'parts/article-empty' ) ?>
            <?php \NV\Theme::archive_nav(array('id' => 'nav-bottom')) ?>
        </div>
        <div id="sidebar" class="small-12 large-4 columns">
            <?php dynamic_sidebar('sidebar-1') ?>
        </div>
    </div>
<?php
\NV\Theme::get_footer();