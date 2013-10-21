<?php
namespace NV;

/**
 * This class should encapsulate any basic features that need to be used directly in the theme files.
 *
 * @TODO: A lot of stuff in here is SLOPPPPPPYYYYY. Rewrite soon.
 */
class Theme
{

    /**
     * Outputs paginated navigation for archive/blog pages. Implements Foundation's pagination structure.
     *
     * max_size must be greater than 11. 13 is default.
     *
     * 'id'          - The id attribute of the pagination element (default: 'nav-generic')
     * 'classes'     - Any classes that need to be added to the nav element.
     * 'page_limit'  - The number of navigation items/pages to show (including next & prev)
     * 'prev_txt'    - The text or html to output inside the "previous page" link (default: &laquo;)
     * 'next_txt'    - The text or html to output inside the "next page" link (default: &raquo;)
     * 'echo'        - Whether to echo the generated object
     *
     * @TODO Is this the best we can do? Let's consider a rewrite.
     *
     * @global \WP_Query $wp_query
     * @global int $paged
     *
     * @param array $args
     *
     * @return string
     */
    public static function archive_nav( $args = array() )
    {
        global $wp_query, $paged;

        //If this isn't an archive, do nothing
        if ( !is_archive() && !is_home() ) {
            return;
        }

        $output   = '';
        $defaults = array(
            'id'        => 'nav-generic',
            'classes'   => 'pagenav archive',
            'page_limit' => 15,
            'prev_txt'  => '&laquo;',
            'next_txt'  => '&raquo;',
            'echo'      => true,
        );
        $args     = wp_parse_args( $args, $defaults );
        extract( $args, EXTR_SKIP );

        /** @var $id string */
        /** @var $classes string */
        /** @var $page_limit string */
        /** @var $prev_txt string */
        /** @var $next_txt string */
        /** @var $echo string */

        //Ensure $max_size is always 11 or greater
        if ( 9 > $page_limit ) {
            $page_limit = 9;
        }

        //Determine half-point
        $page_half = round( $page_limit / 2, 0, PHP_ROUND_HALF_UP );

        //If there aren't multiple pages, no need to do anything
        if ( $wp_query->max_num_pages > 1 ) {

            //Clean up additional classes
            if ( is_array( $classes ) ) {
                $classes = implode( ' ', $classes );
            }
            $classes = esc_attr( $classes );

            $output .= '<nav id="' . $id . '" class="' . $classes . '">';
            $output .= '<ul class="pagination">';


            /************** LEFT ARROW ***************/
            if ( empty( $paged ) || $paged == 1 ) {
                $output .= '<li class="arrow unavailable">';
            }
            else {
                $output .= '<li class="arrow">';
            }
            $output .= '<a href="' . previous_posts( false ) . '" ' . apply_filters( 'previous_posts_link_attributes', '' ) . '>' . preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $prev_txt ) . '</a>';
            $output .= '</li>';
            /************** /LEFT ARROW ***************/


            if ( $wp_query->max_num_pages > $page_limit ) {
                /************** NAV PAGE POSITION END ***************/
                if ( $paged >= ( $wp_query->max_num_pages - $page_half ) ) {

                    $output .= sprintf( '<li class=""><a href="%s">1</a></li>', get_pagenum_link( 1 ) //link
                    );

                    $output .= '<li class="unavailable"><a href="">&hellip;</a></li>';

                    for ( $i = $wp_query->max_num_pages - ( $page_limit - 2 ); $i <= $wp_query->max_num_pages; $i++ ) {

                        $output .= sprintf( '<li class="%s"><a href="%s">%s</a></li>', ( ( empty( $paged ) && 1 == $i ) || $paged == $i ) ? ' current ' : '', //active class
                            get_pagenum_link( $i ), //link
                            $i //page number
                        );
                    } //endfor;
                }
                /************** NAV PAGE POSITION START ***************/
                else if ( $paged < $page_half ) {
                    for ( $i = 1; $i <= $wp_query->max_num_pages; $i++ ) {

                        if ( $i >= $page_limit - 2 ) {
                            $output .= '<li class="unavailable"><a href="">&hellip;</a></li>';
                            $output .= sprintf( '<li class=""><a href="%s">%s</a></li>', get_pagenum_link( $wp_query->max_num_pages ), //link
                                $wp_query->max_num_pages //page number
                            );
                            break;
                        }
                        else {
                            $output .= sprintf( '<li class="%s"><a href="%s">%s</a></li>', ( ( empty( $paged ) && 1 == $i ) || $paged == $i ) ? ' current ' : '', //active class
                                get_pagenum_link( $i ), //link
                                $i //page number
                            );
                        }
                    } //for
                }
                /************** NAV PAGE POSITION MIDDLE ************* */
                else {
                    $loopstart = $paged - round( ( ( $page_limit - 6 ) / 2 ), 0, PHP_ROUND_HALF_DOWN );
                    $loopend   = $paged + round( ( ( $page_limit - 6 ) / 2 ), 0, PHP_ROUND_HALF_DOWN );
                    $loopstart = ( $page_limit & 1 ) ? $loopstart : ++$loopstart; //Correct left pages if $page_limit is even

                    $output .= sprintf( '<li class=""><a href="%s">1</a></li>', get_pagenum_link( 1 ) );
                    $output .= '<li class="unavailable"><a href="">&hellip;</a></li>';
                    for ( $i = $loopstart; $i <= $loopend; $i++ ) {

                        $output .= sprintf( '<li class="%s"><a href="%s">%s</a></li>', ( ( empty( $paged ) && 1 == $i ) || $paged == $i ) ? ' current ' : '', //active class
                            get_pagenum_link( $i ), //link
                            $i //page number
                        );
                    } //for
                    $output .= '<li class="unavailable"><a href="">&hellip;</a></li>';
                    $output .= sprintf( '<li class=""><a href="%s">%s</a></li>', get_pagenum_link( $wp_query->max_num_pages ), //link
                        $wp_query->max_num_pages //page number
                    );
                }
                /** ************ /NAV PAGE POSITION MIDDLE ************* */
            }
            else {
                /** ************** SHORT PAGE LOOP ******************** */
                for ( $i = 1; $i <= $wp_query->max_num_pages; $i++ ) {
                    $output .= sprintf( '<li class="%s"><a href="%s">%s</a></li>', ( ( empty( $paged ) && 1 == $i ) || $paged == $i ) ? ' current ' : '', //active class
                        get_pagenum_link( $i ), //link
                        $i //page number
                    );
                }
                /** ************** SHORT PAGE LOOP ******************** */
            }


            /************** RIGHT ARROW ***************/
            if ( $paged == $wp_query->max_num_pages ) {
                $output .= '<li class="arrow unavailable">';
            }
            else {
                $output .= '<li class="arrow">';
            }
            $output .= '<a href="' . next_posts( $wp_query->max_num_pages, false ) . '" ' . apply_filters( 'next_posts_link_attributes', '' ) . '>' . preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $next_txt ) . '</a>';
            $output .= '</li>';
            /************** /RIGHT ARROW ***************/


            $output .= '</ul>';
            $output .= '</nav>';
        }

        //Output to page...
        if ( $echo ) {
            echo $output;
        }

        return $output;
    }


    /**
     * Can be used instead of wp_link_pages() for showing article-specific pagination. For paginated posts ( posts which
     * use <!--nextpage--> ), this method implements Foundation's pagination structure instead of WordPress's.
     *
     * The following arguments are accepted...
     *
     * 'before' - Start of generated HTML object
     * 'after'  - End of generated HTML object
     * 'page_before' - Element to place before page link.
     * 'link_before' - Place inside link at start of visible text
     * 'link_after'  - Place inside link at end of visible text
     * 'page_after'  - Closing element to place after page link
     * 'echo'        - Whether to echo the generated object
     *
     * @see wp_link_pages()
     *
     * @param string|array $args Optional. Overwrite the defaults.
     *
     * @return string Formatted output in HTML.
     */
    public static function article_page_nav( $args = array() )
    {
        $defaults = array(
            'before'        => '<dl class="page-link sub-nav">' . '<dt>' . __( 'Pages:', 'nvLangScope' ) . '</dt>',
            'page_before'   => '<dd%>', //% represents replacement character for current/active page
            'page_after'    => '</dd>',
            'link_before'   => '',
            'link_after'    => '',
            'after'         => '</dl>',
            'max_size'      => 6,
            'echo'          => true,
        );

        $r = wp_parse_args( $args, $defaults );
        //Plugin compatibility
        $r = apply_filters( 'wp_link_pages_args', $r );
        extract( $r, EXTR_SKIP );

        /** @var $before string */
        /** @var $page_before string */
        /** @var $page_after string */
        /** @var $link_before string */
        /** @var $link_after string */
        /** @var $after string */
        /** @var $max_size string */
        /** @var $echo string */

        global $page, $numpages, $multipage, $more, $pagenow;

        $output = '';

        if ( $multipage ) {
            $output .= $before;

            //Loop through and count pages...
            for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
                //Set the page number
                $pagenum = $i;

                //Add a white space...
                $output .= ' ';

                //Generate a link only if it isn't the current page
                if ( ( $i != $page ) || ( ( !$more ) && ( $page == 1 ) ) ) {
                    //Is NOT the current page
                    $output .= preg_replace( '/%/', '', $page_before );
                }
                else {
                    //Current page...
                    $output .= preg_replace( '/%/', ' class="active" ', $page_before );
                }

                $output .= _wp_link_page( $i ); //$link_start;
                $output .= $link_before;
                $output .= $pagenum;
                $output .= $link_after;
                $output .= '</a>'; //$link_end;
                $output .= $page_after;
            }

            $output .= $after;
        }

        if ( $echo ) {
            echo $output;
        }

        return $output;
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
    public static function breadcrumbs( $args = array() )
    {
        global $post, $wp_query;

        $defaults = array(
            'use_prefix'  => true, 'blog_title' => __( 'Blog', 'nvLangScope' ), 'before' => '<ul class="breadcrumbs">',
            'after'       => '</ul>', 'crumb_before' => '<li%>',
            //% represents replacement character for current/active page
            'crumb_after' => '</li>', 'echo' => true,
        );

        $r = wp_parse_args( $args, $defaults );
        $r = apply_filters( 'wp_link_pages_args', $r );
        extract( $r, EXTR_SKIP );

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
        $output .= '<li><a href="' . get_home_url() . '">' . __( 'Home', 'nvLangScope' ) . '</a></li>';

        //Determine content of breadcrumb...
        if ( is_singular() ) {
            $ancestors = get_post_ancestors( $post );

            if ( $use_prefix && !is_page() ) {
                //Get the url for the archive (get_home_url() must be used for the built-in 'post' post type)
                $archive_url = get_post_type_archive_link( $post->post_type ) ? : get_home_url();
                //What is the NAME of this items archive?
                $ptype_title = ( is_singular( 'post' ) ) ? $blog_title : get_post_type_object( $post->post_type )->label;
                //Add archive to the breadcrumb bar
                $output .= '<li><a href="' . $archive_url . '">' . $ptype_title . '</a></li>';
            }

            foreach ( $ancestors as $ancestor ) {
                //Output each ancestor if a page has them
                $output .= '<li><a href="' . get_permalink( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
            }

            //Output current page but mark it as current
            $output .= '<li class="current"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        else if ( \NV\WordPress::is_tax_archive() ) {

            $output .= '<li class="unavailable"><a href="">' . get_taxonomy( $query_obj->taxonomy )->label . '</a></li>';
            $output .= '<li class="current"><a href="' . get_pagenum_link() . '">' . $query_obj->name . '</a></li>';
        }
        else if ( is_post_type_archive() ) {
            $output .= '<li class="current"><a href="' . get_post_type_archive_link( $post->post_type ) . '">' . $query_obj->label . '</a></li>';
        }
        else if ( is_search() ) {
            $output .= '<li class="current"><a href="/?s=' . $_REQUEST[ 's' ] . '">' . __( 'Search: ', 'nvLangScope' ) . urldecode( $_REQUEST[ 's' ] ) . '</a></li>';
        }
        else if ( is_year() ) {
            $output .= '<li class="current"><a href="/?m=' . $_REQUEST[ 'm' ] . '">' . __( 'Year: ', 'nvLangScope' ) . get_the_date( 'Y' ) . '</a></li>';
        }
        else if ( is_month() ) {
            $output .= '<li class="current"><a href="/?m=' . $_REQUEST[ 'm' ] . '">' . __( 'Month: ', 'nvLangScope' ) . get_the_date( 'F Y' ) . '</a></li>';
        }
        else if ( is_date() ) {
            $output .= '<li class="current"><a href="/?m=' . $_REQUEST[ 'm' ] . '">' . __( 'Date: ', 'nvLangScope' ) . get_the_date( 'F d, Y' ) . '</a></li>';
        }

        //Closing tag...
        $output .= $after;

        if ( $echo ) {
            echo $output;
        }

        return $output;
    }


    /**
     * This loads the template for individual comments. It is called from within the comments template
     * ( parts/comments.php ) file like so:
     *
     * <code>
     * <?php
     *    wp_list_comments( array( 'callback' => array( '\NV\Theme', 'comments' ) ) );
     * ?>
     * </code>
     *
     * @param $comment
     * @param array $args
     * @param int $depth
     */
    public static function comments( $comment, $args = array(), $depth = 1 )
    {
        require NV_PATH . '/parts/comments-single.php';
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
    public static function get_footer( $name = null, $path = 'layout/' )
    {
        do_action( 'get_footer', $name );

        //Ensure path has closing slash
        $path = trailingslashit( $path );

        $templates = array();
        if ( isset( $name ) ) {
            $templates[ ] = "{$path}footer-{$name}.php";
        }
        else {
            $templates[ ] = "{$path}footer.php";
        }

        // Backward compat code will be removed in a future release
        if ( '' == locate_template( $templates, true ) ) {
            trigger_error( "The specified footer ( {$templates[0]} ) was not found..." , E_USER_ERROR);
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
    public static function get_header( $name = null, $path = 'layout/' )
    {
        do_action( 'get_header', $name );

        //Ensure path has closing slash
        $path = trailingslashit( $path );

        $templates = array();
        if ( isset( $name ) ) {
            $templates[ ] = "{$path}header-{$name}.php";
        }
        else {
            $templates[ ] = "{$path}header.php";
        }

        // Backward compat code will be removed in a future release
        if ( '' == locate_template( $templates, true ) ) {
            trigger_error( "The specified header ( {$templates[0]} ) was not found..." , E_USER_ERROR);
        }
    }


    /**
     * Shortcut to simplify a standard loop.
     *
     * @TODO Either extend this method or create a new version that can take a custom WP_Query query
     *
     * @param string $part The template part to load
     * @param string $no_part The template part to load if there are no results
     */
    public static function loop( $part, $no_part='' )
    {
        // START the loop
        if ( have_posts() )
        {
            while ( have_posts() )
            {
                the_post();
                get_template_part( $part, get_post_format() );
            }
        }
        else if ( ! empty($no_part) )
        {
            get_template_part( $no_part );
        }
        // END the loop
    }


    /**
     * Outputs the name of the file as an HTML comment for easy-peesy troubleshooting.
     *
     * @param string $file This function should always be passed the value of __FILE__
     */
    public static function output_file_marker( $file )
    {
        // Strip out system path (keeping only site-root-relative path)
        $file = preg_replace( '|' . preg_quote( ABSPATH ) . '|', '', $file );

        // Output an HTML comment with the current template path
        printf( "\n\n<!-- ".__( 'Template file: %s', 'nvLangScope' )." -->\n\n", '/'.$file );
    }


    /**
     * Generates a page <title>
     *
     * @global object $page
     * @global int $paged
     */
    public static function page_title()
    {
        global $page, $paged;

        wp_title( '|', true, 'right' );
        bloginfo( 'name' );
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            echo " | $site_description";
        }
        if ( $paged >= 2 || $page >= 2 ) {
            echo ' | ' . sprintf( __( 'Page %s', 'nvLangScope' ), max( $paged, $page ) );
        }
    }


    /**
     * Displays information about a post. Author, post date, etc.
     *
     * Example: Posted on July 4, 2012 by Matt
     */
    public static function posted_on()
    {
        // Full HTML5 datetime for datetime attr
        $dt_html = esc_attr( get_the_date( 'c' ) );

        // Visible date
        $dt_text = esc_html( get_the_date() );

        // Author archive LINK
        $author_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );

        //Author title attribute
        $author_tooltip = esc_attr( sprintf( __( 'View all posts by %s', 'nvLangScope' ), get_the_author() ) );

        // Author name
        $author_name = get_the_author();

        // OUTPUT THE HTML
        printf( '<span class="posted-on">'.__( 'Posted on %s by %s', 'nvLangScope' ).'</span>',
            // Date and time...
            "<time datetime='{$dt_html}' pubdate>{$dt_text}</time>",
            // Author vcard and link...
            "<span class='author vcard'><a href='{$author_url}' title='{$author_tooltip}' rel='author'>{$author_name}</a></span>"
        );
    }

}