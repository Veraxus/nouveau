<?php
namespace NV;

/**
 * This class should encapsulate any basic features that need to be used directly in the theme files.
 *
 * @TODO: A lot of stuff in here is SLOPPPPPPYYYYY. Especially the menu generation/walker. Rewrite soon.
 */
class Theme
{

    /**
     * Outputs paginated navigation for archive pages. Implements Foundation's
     * pagination structure.
     *
     * max_size must be greater than 11. 13 is default.
     *
     * 'id'          - The id attribute of the pagination element (default: 'nav-generic')
     * 'classes'     - Any classes that need to be added to the nav element.
     * 'page_limit'  - The number of navigation items/pages to show (including next & prev)
     * 'prev_txt'    - The text or html to output inside the "previous page" link (default: &laquo;)
     * 'next_txt'    - The text or html to output inside the "next page" link (default: &raquo;)
     * 'echo'        - Whether to echo the generated object
     *A
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
            'id'       => 'nav-generic', 'classes' => 'pagenav archive', 'page_limit' => 15, 'prev_txt' => '&laquo;',
            'next_txt' => '&raquo;', 'echo' => true,
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

            //if page 1, no previous
            if ( empty( $paged ) || $paged == 1 ) {
                $output .= '<li class="unavailable">';
            }
            else {
                $output .= '<li>';
            }

            $output .= '<a href="' . previous_posts( false ) . '" ' . apply_filters( 'previous_posts_link_attributes', '' ) . '>' . preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $prev_txt ) . '</a>';
            $output .= '</li>';

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
                /*				 * ************ /NAV PAGE POSITION MIDDLE ************* */
            }
            else {
                /*				 * ************** SHORT PAGE LOOP ******************** */
                for ( $i = 1; $i <= $wp_query->max_num_pages; $i++ ) {
                    $output .= sprintf( '<li class="%s"><a href="%s">%s</a></li>', ( ( empty( $paged ) && 1 == $i ) || $paged == $i ) ? ' current ' : '', //active class
                        get_pagenum_link( $i ), //link
                        $i //page number
                    );
                }
                /*				 * ************** SHORT PAGE LOOP ******************** */
            }

            //if page last
            if ( $paged == $wp_query->max_num_pages ) {
                $output .= '<li class="unavailable">';
            }
            else {
                $output .= '<li>';
            }
            $output .= '<a href="' . next_posts( $wp_query->max_num_pages, false ) . '" ' . apply_filters( 'next_posts_link_attributes', '' ) . '>' . preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $next_txt ) . '</a>';
            $output .= '</li>';

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
            'before'      => '<dl class="page-link sub-nav">' . '<dt>' . __( 'Pages:', 'nvLangScope' ) . '</dt>',
            'page_before' => '<dd%>', //% represents replacement character for current/active page
            'page_after'  => '</dd>', 'link_before' => '', 'link_after' => '', 'after' => '</dl>', 'max_size' => 6,
            'echo'        => true,
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
     * Includes the footer template for a theme or if a name is specified then a
     * specialised footer will be included.
     *
     * For the parameter, if the file is called "footer-special.php" then specify
     * "special".
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

        $templates[ ] = "{$path}footer.php";

        // Backward compat code will be removed in a future release
        if ( '' == locate_template( $templates, true ) ) {
            load_template( ABSPATH . WPINC . '/theme-compat/footer.php' );
        }
    }


    /**
     * Load header template.
     *
     * Includes the header template for a theme or if a name is specified then a
     * specialised header will be included.
     *
     * For the parameter, if the file is called "header-special.php" then specify
     * "special".
     *
     * @uses locate_template()
     * @uses do_action() Calls 'get_header' action.
     *
     * @param string $name The name of the specialised header.
     * @param sting $path The theme-relative path to the header file (with closing slash).
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

        $templates[ ] = "{$path}header.php";

        // Backward compat code will be removed in a future release
        if ( '' == locate_template( $templates, true ) ) {
            load_template( ABSPATH . WPINC . '/theme-compat/header.php' );
        }
    }


    /**
     * Generates a page <title>
     *
     * @global type $page
     * @global type $paged
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
        printf( __( '<span class="posted-on">Posted on <time datetime="%1$s" pubdate>%2$s</time> by <span class="author vcard"><a href="%3$s" title="%4$s" rel="author">%5$s</a></span></span>', 'nvLangScope' ), esc_attr( get_the_date( 'c' ) ), // 1. Full HTML5 datetime for datetime attr
            esc_html( get_the_date() ), // 2. Visible date
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), // 3. Author archive link
            esc_attr( sprintf( __( 'View all posts by %s', 'nvLangScope' ), get_the_author() ) ), // 4. Author link title attr
            get_the_author() // 5. Visible author name
        );
    }


    /**
     * This renders a custom-defined menu in Foundation-compatible format. If no custom menu is defined,
     * an alert box appears. Unlike the default functionality of wp_nav_menu(), this will NOT automatically generate
     * menus (because automatically generated menus suck).
     *
     * @param string $menu_slug The name/id/slug of the menu to use.
     * @param bool $mobile If true, this will be rendered as a mobile menu.
     */
    public static function topbar( $menu_slug, $mobile = false )
    {
        // Fallback... this will display if there is no menu defined
        $fallback_cb = function ( $args ) {
            printf( '<div class="alert-box secondary">%s</div>', sprintf( __( 'The "%s" menu has not been defined! You can <a href="%s">hard-code one</a>, or <a href="%s">create it in WordPress.</a>', 'nvLangScope' ), $args[ 'theme_location' ], 'http://foundation.zurb.com/docs/navigation.php#nav-bar', get_admin_url( '', 'nav-menus.php' ) ) );
        };

        // Let's generate the menu
        wp_nav_menu( array(
                          'theme_location'  => $menu_slug,
                          'items_wrap'      => '<ul id="%1$s" class="nav-bar %2$s">%3$s</ul>',
                          'walker'          => new \NV\FoundationMenuWalker,
                          'container_class' => ( $mobile ) ? 'show-for-small' : 'hide-for-small',
                          'fallback_cb'     => $fallback_cb,
                     ) );
    }


    /**
     * Outputs the name of the file for troubleshooting.
     *
     * @param string $file This function should always be passed the value of __FILE__
     */
    public static function output_file_marker( $file )
    {
        $file = preg_replace( '|' . preg_quote( ABSPATH ) . '|', '', $file );
        printf( __( '<!-- Template file: /%s -->', 'nvLangScope' ), $file );
    }

    /**
     * Shortcut to simplify a standard loop.
     *
     * @param $part The template part to load
     * @param $nopart The template part to load if there are no results
     */
    public static function loop( $part, $nopart='' )
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
        else if ( ! empty($nopart) )
        {
            get_template_part( $nopart );
        }
        // END the loop
    }

}