<?php
/**
 * SINGLE BLOG POSTS
 *
 * This is the template for single, full-page blog posts.
 */

use \NV\Theme\Core\Theme;

Theme::get_header();
Theme::output_file_marker(__FILE__);
the_post();
?>
    <div id="container" class="grid-container">
        <div class="grid-x grid-padding-x">
            <div id="content" class="cell small-12 large-8">
                <?php Theme::get_part('article-with-comments') ?>
            </div>
            <div id="sidebar" class="cell small-12 large-4">
                <?php dynamic_sidebar('sidebar-1') ?>
            </div>
        </div>
    </div>
<?php
Theme::get_footer();