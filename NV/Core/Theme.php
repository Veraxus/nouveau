<?php

namespace NV\Theme\Core;

use NV\Theme\Core;

/**
 * Basic features to be used in theme template files.
 */
class Theme
{

    /**
     * Next/Prev navigation for archives.
     *
     * Simply loads /templates/parts/archive-nav.php
     */
    public static function archive_nav()
    {
        self::get_part('archive-nav');
    }

    /**
     * Pagination for archives.
     *
     * By default, this uses WordPress's built-in paginate_links() function, but it can be replaced with your own logic.
     *
     * @param array $args
     */
    public static function archive_pagination($args = [])
    {
        echo paginate_links($args);
    }

    /**
     * Displays pagination for a paginated post/page/article.
     *
     * By default, this uses WordPress' built-in wp_link_pages() function, but it can replaced with your own logic.
     *
     * @param array $args
     */
    public static function page_pagination($args = [])
    {
        echo wp_link_pages($args);
    }


    /**
     * Can be used to output breadcrumbs. Implements Foundation's breadcrumb structure.
     *
     * @global \WP_Query $wp_query
     * @global object $post
     *
     * @param array $args
     *
     * @return string
     */
    public static function breadcrumbs($args = [])
    {
        global $post, $wp_query;

        $defaults = [
            'use_prefix'   => true,
            'blog_title'   => __('Blog', 'nv_lang_scope'),
            'before'       => '<ul class="breadcrumbs">',
            'after'        => '</ul>',
            'crumb_before' => '<li%>',
            //% represents replacement character for current/active page
            'crumb_after'  => '</li>',
            'echo'         => true,
        ];

        $r = wp_parse_args($args, $defaults);
        $r = apply_filters('wp_link_pages_args', $r);
        extract($r, EXTR_SKIP);

        /** @var $use_prefix */
        /** @var $blog_title */
        /** @var $before */
        /** @var $after */
        /** @var $crumb_before */
        /** @var $crumb_after */
        /** @var $echo */

        $query_obj = $wp_query->get_queried_object();

        //Open tag...
        $output = $before;
        $output .= '<li><a href="' . get_home_url() . '">' . __('Home', 'nv_lang_scope') . '</a></li>';

        //Determine content of breadcrumb...
        if (is_singular()) {
            $ancestors = get_post_ancestors($post);

            if ($use_prefix && !is_page()) {
                //Get the url for the archive (get_home_url() must be used for the built-in 'post' post type)
                $archive_url = get_post_type_archive_link($post->post_type) ?: get_home_url();
                //What is the NAME of this items archive?
                $ptype_title = (is_singular('post')) ? $blog_title : get_post_type_object($post->post_type)->label;
                //Add archive to the breadcrumb bar
                $output .= '<li><a href="' . $archive_url . '">' . $ptype_title . '</a></li>';
            }

            foreach ($ancestors as $ancestor) {
                //Output each ancestor if a page has them
                $output .= '<li><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
            }

            //Output current page but mark it as current
            $output .= '<li class="current"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        } else {
            if (WordPress::is_tax_archive()) {
                $output .= '<li class="unavailable"><a href="">' . get_taxonomy($query_obj->taxonomy)->label . '</a></li>';
                $output .= '<li class="current"><a href="' . get_pagenum_link() . '">' . $query_obj->name . '</a></li>';
            } else {
                if (is_post_type_archive()) {
                    $output .= '<li class="current"><a href="' . get_post_type_archive_link($post->post_type) . '">' . $query_obj->label . '</a></li>';
                } else {
                    if (is_search()) {
                        $output .= '<li class="current"><a href="/?s=' . $_REQUEST['s'] . '">' . __('Search: ',
                                'nv_lang_scope') . urldecode($_REQUEST['s']) . '</a></li>';
                    } else {
                        if (is_year()) {
                            $output .= '<li class="current"><a href="/?m=' . $_REQUEST['m'] . '">' . __('Year: ',
                                    'nv_lang_scope') . get_the_date('Y') . '</a></li>';
                        } else {
                            if (is_month()) {
                                $output .= '<li class="current"><a href="/?m=' . $_REQUEST['m'] . '">' . __('Month: ',
                                        'nv_lang_scope') . get_the_date('F Y') . '</a></li>';
                            } else {
                                if (is_date()) {
                                    $output .= '<li class="current"><a href="/?m=' . $_REQUEST['m'] . '">' . __('Date: ',
                                            'nv_lang_scope') . get_the_date('F d, Y') . '</a></li>';
                                }
                            }
                        }
                    }
                }
            }
        }

        //Closing tag...
        $output .= $after;

        if ($echo) {
            echo $output;
        }

        return $output;
    }

    /**
     * Loads NOUVEAU comments templates from their special place in templates/parts
     *
     * @param $file
     */
    public static function comments($file = 'comments.php')
    {
        comments_template('/' . Core::i()->paths->parts('comments/' . $file, true));
    }

    /**
     * Load footer template.
     *
     * Includes the footer template for a theme or if a name is specified then a specialised footer will be included.
     *
     * For the parameter, if the file is called "footer-special.php" then specify "special".
     *
     * @uses locate_template()
     * @uses do_action() Calls 'get_footer' action.
     *
     * @param string $name The name of the specialised footer.
     * @param string $path
     */
    public static function get_footer($name = null, $path = 'templates/parts/layout/')
    {
        do_action('get_footer', $name);

        //Ensure path has closing slash
        $path = trailingslashit($path);

        $templates = [];
        if (isset($name)) {
            $templates[] = "{$path}footer-{$name}.php";
        } else {
            $templates[] = "{$path}footer.php";
        }

        // Backward compat code will be removed in a future release
        if ('' == locate_template($templates, true)) {
            trigger_error("The specified footer ( {$templates[0]} ) was not found...", E_USER_ERROR);
        }
    }


    /**
     * Load a header template.
     *
     * This allows you to load a header template from any specified path and/or file name. By default, this will look
     * in the theme's /layout/ folder, unless otherwise specified.
     *
     * For the parameter, if the file is called "header-special.php" then specify "special".
     *
     * @uses locate_template()
     * @uses do_action() Calls 'get_header' action.
     *
     * @param mixed $name The name of the specialised header (note: will be prepended with "header-")
     * @param string $path The theme-relative path to the header file.
     */
    public static function get_header($name = null, $path = 'templates/parts/layout/')
    {
        do_action('get_header', $name);

        //Ensure path has closing slash
        $path = trailingslashit($path);

        $templates = [];
        if (isset($name)) {
            $templates[] = "{$path}header-{$name}.php";
        } else {
            $templates[] = "{$path}header.php";
        }

        // Backward compat code will be removed in a future release
        if ('' == locate_template($templates, true)) {
            trigger_error("The specified header ( {$templates[0]} ) was not found...", E_USER_ERROR);
        }
    }


    /**
     * Shortcut to simplify a standard loop. You simply provide a template part path and the loop is handled for you.
     *
     * @param string $part The template part to load
     * @param string $no_part The template part to load if there are no results
     */
    public static function loop($part, $no_part = '')
    {
        // START the loop
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                self::get_part($part, get_post_format());
            }
        } else {
            if (!empty($no_part)) {
                self::get_part($no_part);
            }
        }
        // END the loop
    }


    /**
     * Shortcut to simplify a loop that uses a custom query. You can provide either a WP_Query object or an array of
     * query arguments if you want the object created for you. The loop will then be performed and the appropriate
     * specified template part will be loaded. You can also specify a custom name for the query object variable to
     * prevent collisions.
     *
     * Note that template parts are loaded by include, NOT by get_template_part(). This is because get_template_part()
     * blocks access to the custom query variable unless a global statement pulls it into the template.
     *
     * @param mixed $query Required. Either a WP_Query object or an array of arguments to perform a new query.
     * @param string $part Required. The theme-relative template part to load.
     * @param string $part_noresults Optional. The theme-relative template part to load if there are no results.
     * @param string $var_name Optional. The variable name (without $) you want to use for accessing the query within template parts. Default: 'query'.
     *
     * @return bool Returns false if nothing to show.
     */
    public static function custom_loop($query, $part, $part_noresults = '', $var_name = 'data')
    {

        // Set up the custom named query variable
        if (is_array($query) || is_string($query)) {
            $$var_name = new \WP_Query($query);
        } else {
            if (is_a($query, '\WP_Query')) {
                $$var_name = &$query;
            } else {
                return false;
            }
        }

        /**
         * HOOK: 'nv_custom_loop_' . $var_name
         *
         * Fires inside custom_loop calls after the query is run but before the
         * template loop begins.
         *
         * The dynamic portion of the hook name, `$var_name`, refers to the name
         * of the variable specified for storing the query object.
         *
         * @since 1.0.0
         *
         * @param \WP_Query|\WP_Error $$var_name WP_Query object if the query succeeded. WP_Error object otherwise.
         */
        do_action('nv_custom_loop_' . $var_name, $$var_name);

        // START the loop
        if ($$var_name->have_posts()) {
            while ($$var_name->have_posts()) {
                $$var_name->the_post();
                do_action("get_template_part_{$part}", $part, null);
                $file = Core::i()->paths->theme($part . '.php');
                include $file;
            }
        } else {
            if (!empty($part_noresults)) {
                do_action("get_template_part_{$part}", $part, null);
                $file = Core::i()->paths->theme($part_noresults . '.php');
                include $file;
            }
        }

        /**
         * HOOK: 'nv_custom_loop_' . $var_name . '_after'
         *
         * Fires inside custom_loop calls after the loop has been executed but
         * before the query is reset.
         *
         * The dynamic portion of the hook name, `$var_name`, refers to the name
         * of the variable specified for storing the query object.
         *
         * @since 1.0.0
         *
         * @param \WP_Query|\WP_Error $$var_name WP_Query object if the query succeeded. WP_Error object otherwise.
         */
        do_action('nv_custom_loop_' . $var_name . '_after', $$var_name);

        wp_reset_query();
    }

    /**
     * Loads a template part into a template.
     *
     * Provides a simple mechanism for child themes to overload reusable sections of code
     * in the theme.
     *
     * Includes the named template part for a theme or if a name is specified then a
     * specialised part will be included. If the theme contains no {slug}.php file
     * then no template will be included.
     *
     * The template is included using require, not require_once, so you may include the
     * same template part multiple times.
     *
     * For the $name parameter, if the file is called "{slug}-special.php" then specify
     * "special".
     *
     * @param string $slug The slug name for the generic template.
     * @param string $name The name of the specialised template.
     */
    public static function get_part($slug, $name = null, $path = 'templates/parts/')
    {
        /**
         * Fires before the specified template part file is loaded.
         *
         * The dynamic portion of the hook name, `$slug`, refers to the slug name
         * for the generic template part.
         *
         * @param string $slug The slug name for the generic template.
         * @param string|null $name The name of the specialized template.
         */
        do_action("get_template_part_{$slug}", $slug, $name);

        $templates = [];
        $name = (string)$name;
        if ('' !== $name) {
            $templates[] = "{$path}{$slug}-{$name}.php";
        }

        $templates[] = "{$path}{$slug}.php";

        locate_template($templates, true, false);
    }

    /**
     * Outputs the name of the file as an HTML comment for easy-peesy troubleshooting.
     *
     * @param string $file This function should always be passed the value of __FILE__
     */
    public static function output_file_marker($file)
    {

        // Don't output this info if WP_DEBUG is off
        if (!WP_DEBUG) {
            return;
        }

        // Strip out system path (keeping only site-root-relative path)
        $file = preg_replace('|' . preg_quote(ABSPATH) . '|', '', $file);

        // Output an HTML comment with the current template path
        printf("\n\n<!-- " . __('Template file: %s', 'nv_lang_scope') . " -->\n\n", '/' . $file);
    }

    /**
     * Displays information about a post. Author, post date, etc.
     *
     * Example: Posted on July 4, 2012 by Matt
     */
    public static function posted_on()
    {
        // Full HTML5 datetime for datetime attr
        $dt_html = esc_attr(get_the_date('c'));

        // Visible date
        $dt_text = esc_html(get_the_date());

        // Author archive LINK
        $author_url = esc_url(get_author_posts_url(get_the_author_meta('ID')));

        //Author title attribute
        $author_tooltip = esc_attr(sprintf(__('View all posts by %s', 'nv_lang_scope'), get_the_author()));

        // Author name
        $author_name = get_the_author();

        // OUTPUT THE HTML
        printf(
            '<span class="posted-on">' . __('Posted on %s by %s', 'nv_lang_scope') . '</span>',
            // Date and time...
            "<time datetime='{$dt_html}' pubdate>{$dt_text}</time>",
            // Author vcard and link...
            "<span class='author vcard'><a href='{$author_url}' title='{$author_tooltip}' rel='author'>{$author_name}</a></span>"
        );
    }

}