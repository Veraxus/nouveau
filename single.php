<?php
/**
 * SINGLE BLOG POSTS
 * 
 * This is the template for single, full-page blog posts.
 */
\NV\Theme::get_header();
\NV\Theme::output_file_marker( __FILE__ );
?>
    <div id="container" class="row">
        <div id="content" class="small-12 large-8 columns">
            <?php \NV\Theme::loop( 'parts/article-with-comments', 'parts/article-empty' ) ?>
        </div>
        <div id="sidebar" class="small-12 large-4 columns">
            <?php dynamic_sidebar( 'sidebar-1' ) ?>
        </div>
    </div>
<?php
\NV\Theme::get_footer();