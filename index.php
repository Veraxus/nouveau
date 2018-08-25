<?php
/**
 * DEFAULT TEMPLATE
 *
 * This is the global default template. If WordPress can't find a more appropriate, specific template file,
 * it will use this one.
 */

use \NV\Theme\Core\Theme;

Theme::get_header();
Theme::output_file_marker(__FILE__);
?>
    <div id="container" class="grid-container">
        <div class="grid-x grid-padding-x">
            <div id="content" class="cell small-12 large-8">
                <?php //Theme::archive_nav( array( 'id' => 'nav-top' ) ) ?>
                <?php wp_link_pages(); ?>

                <?php Theme::loop('parts/article', 'parts/article-empty') ?>

                <?php paginate_links(); ?>

                <?php get_template_part('parts/archive-nav') ?>
            </div>

            <div id="sidebar" class="cell small-12 large-4">
                <?php dynamic_sidebar('sidebar-1') ?>
            </div>

        </div>
    </div>
<?php
Theme::get_footer();