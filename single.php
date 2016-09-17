<?php
/**
 * SINGLE BLOG POSTS
 *
 * This is the template for single, full-page blog posts.
 */
use \NV\Theme\Utilities\Theme;

Theme::get_header();
Theme::output_file_marker( __FILE__ );
the_post();
?>
	<div id="container" class="row">
		<div id="content" class="small-12 large-8 columns">
			<?php get_template_part( 'parts/article-with-comments' ) ?>
		</div>
		<div id="sidebar" class="small-12 large-4 columns">
			<?php dynamic_sidebar( 'sidebar-1' ) ?>
		</div>
	</div>
<?php
Theme::get_footer();