<?php
namespace NV\Hooks;

/**
 * Contains functions for reconfiguring the admin back-end. Generally, method names should match the hook name for
 * easy identification. In cases where a generic hook is utilized, a more logical method name should be used.
 */
class Config {


    /**
     * Sets up basic theme features.
     *
     * Used by action hook: 'after_setup_theme'
     *
     * @uses self::languages();
     */
    public static function after_setup_theme() {
        load_theme_textdomain( 'nvLangScope', trailingslashit(THEME_DIR).'assets/languages' );

        /*
         * Uncomment to allow WordPress to automatically generate a title tag for your pages using the wp_head() hook.
         * This has been available since WordPress 4.1.
         */
        //add_theme_support( 'title-tag' );
        
        add_theme_support( 'automatic-feed-links'); // Automatically generate RSS feed urls
        
        add_theme_support( 'custom-header', array(
            'height'        => 200,
            'width'         => 980,
            'flex-height'   => true,
            'flex-width'    => true,
            'default-image' => 'http://placehold.it/980x200', //or use something like '%s/assets/images/headers/img.jpg',
            //'random-default'      => false,
            //'header-text'         => true,    //Bool. Allow header text?
            //'default-text-color'  => '',
            //'uploads'             => true,    //Allow upload of custom headers
            //'wp-head-callback'    => '',
            //'admin-head-callback' => '',
            //'admin-preview-callback => '',
        ));
        
        add_theme_support( 'custom-background', array(
            //'default-image'             => '',
            'default-color'               => '#fff',
            //'wp-head-callback'          => '_custom_background_cb',
            //'admin-head-callback'       => '',
            //'admin-preview-callback'    => '',
        ));
        
        add_theme_support( 'post-thumbnails' );
        
        add_theme_support( 'post-formats', array(
            'aside',
            'audio',
            'chat',
            'gallery',
            'image',
            'link',
            'quote',
            'status',
            'video',
        ));

        /*
         * Uncomment this if you want to add WooCommerce support to your theme. You should also add a "woocommerce" 
         * folder to your theme root if you want to use custom templates.
         */
        //add_theme_support( 'woocommerce' );

        register_nav_menu( 'primary', __('Primary Menu', 'nvLangScope' ));
        register_nav_menu( 'footer', __('Footer Menu', 'nvLangScope' ));

        /*
         * Set up any default values needed for theme options. If a default value
         * is needed, it can be provided as a second parameter. This will NOT
         * overwrite any existing options with these names.
         */
        add_option( 'register_notify', true ); //Setting for registration notifications to admins
        add_option( 'password_notify', true ); //Setting for password reset notifications to admins
        //add_option( 'nouveau_example_checkbox' );
        //add_option( 'nouveau_example_radio' );
        //add_option( 'nouveau_example_text', 'This is example default text.' );
        //add_option( 'nouveau_example_select' );

    }


    /**
     * Enqueues styles and scripts. 
     * 
     * This is current set up for the majority of use-cases, and you can uncomment additional lines if you want to 
     *
     * Used by action hook: 'wp_enqueue_scripts'
     */
    public static function enqueue_assets() {

        /******************
         * STYLES / CSS
         ******************/
        
        // Base stylesheet (compiled SASS)
        wp_enqueue_style( 'app', NV_CSS.'/app.css' );

        // WordPress's required styles.css (will override compiled SASS)
        wp_enqueue_style( 'styles', get_bloginfo( 'stylesheet_url' ), array( 'app' ) );


        /******************
         * SCRIPTS / JS
         ******************/
        
        // Load Modernizr in the head...
        wp_enqueue_script( 'modernizr', NV_ZF_JS.'/vendor/modernizr.js', array(), '2.8.2' );

        // Remove WordPress's jQuery and use our own...
        wp_deregister_script( 'jquery' );
        wp_enqueue_script( 'jquery', NV_ZF_JS.'/vendor/jquery.js', array(), '2.1.1' );
        
        // Load fastclick (optional)...
        wp_enqueue_script( 'fastclick',  NV_ZF_JS.'/vendor/fastclick.js', array(), '1.0.2' );

        // Load jQuery.cookie (optional)...
        //wp_enqueue_script( 'jq-cookie', NV_ZF_JS.'/vendor/jquery.cookie.js' );
        
        // Load jQuery.placeholder (optional)...
        //wp_enqueue_script( 'jq-placeholder', NV_ZF_JS.'/vendor/placeholder.js' );
        
        // Load the complete version of Foundation (with all plugins)...
        wp_enqueue_script( 
            'foundation',                                   // uid
            NV_ZF_JS.'/foundation.min.js',                  // url
            array( 'jquery' ),                              // dependencies (by uid)
            '5.4.6',                                        // version id (optional)
            true                                            // load in footer?
        );
        
        // Load any Foundation stuff individually (optional)...
        //wp_enqueue_script( 'foundation', NV_ZF_JS.'/foundation/foundation.js', array( 'jquery' ), false, true );
        //wp_enqueue_script( 'zf-abide', NV_ZF_JS.'/foundation/foundation.abide.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-accordion', NV_ZF_JS.'/foundation/foundation.accordion.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-alert', NV_ZF_JS.'/foundation/foundation.alert.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-clearing', NV_ZF_JS.'/foundation/foundation.clearing.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-dropdown', NV_ZF_JS.'/foundation/foundation.dropdown.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-equalizer', NV_ZF_JS.'/foundation/foundation.equalizer.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-interchange', NV_ZF_JS.'/foundation/foundation.equalizer.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-joyride', NV_ZF_JS.'/foundation/foundation.joyride.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-magellan', NV_ZF_JS.'/foundation/foundation.magellan.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-offcanvas', NV_ZF_JS.'/foundation/foundation.offcanvas.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-orbit', NV_ZF_JS.'/foundation/foundation.orbit.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-reveal', NV_ZF_JS.'/foundation/foundation.reveal.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-slider', NV_ZF_JS.'/foundation/foundation.slider.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-tab', NV_ZF_JS.'/foundation/foundation.tab.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-tooltip', NV_ZF_JS.'/foundation/foundation.tooltip.js', array( 'foundation' ), false, true );
        //wp_enqueue_script( 'zf-topbar', NV_ZF_JS.'/foundation/foundation.topbar.js', array( 'foundation' ), false, true );

        // Load any custom javascript (remember to update dependencies if you changed the above)...
        wp_enqueue_script( 
            'theme-app',                                    // uid
            NV_JS.'/app.min.js',                            // url
            array( 'jquery', 'foundation', 'modernizr' ),   // dependencies (by uid)
            false,                                          // version id (optional)
            true                                            // load in footer?
        );

    }


    /**
     * Enqueues styles and scripts for the admin section
     *
     * Used by action hook: 'admin_enqueue_scripts'
     */
    public static function enqueue_admin_assets() {
        // Base admin styles
        wp_enqueue_style( 'nv-admin', NV_CSS.'/admin.css' );

        // Base admin scripts
        wp_enqueue_script( 'nv-admin', NV_JS.'/admin.min.js', array('jquery'), false, false );
    }


    /**
     * This ensures that the 'sticky' class doesn't appear in any WordPress posts as that class has a very specific
     * function within Foundation (elements with that class will "stick" to the top of the window when you scroll
     * down). To get the best of both worlds, this function dynamically replaces WordPress's built-in 'sticky' class
     * with 'sticky-post' instead.
     *
     * Used by action hook: 'post_class'
     */
    public static function fix_sticky_class($classes) {
        $classes = array_diff( $classes, array( "sticky" ) );
        if ( is_sticky() ) {
            $classes[] = 'sticky-post';
        }
        return $classes;
    }


    /**
     * UNUSED.
     * Loads alternate languages, if available.
     *
     * @deprecated
     * @see self::setup()
     */
    public static function languages() {
        load_theme_textdomain( 'nvLangScope', trailingslashit(THEME_DIR).'assets/languages');

        $locale = get_locale();

        $locale_file = sprintf( '%s/assets/languages/%s.php', untrailingslashit(THEME_DIR), $locale);
        if ( is_readable( $locale_file ) ) {
            require_once $locale_file;
        }
    }


    /**
     * Allows further customizations of the body_class() function.
     *
     * @param $classes
     * @param $args
     */
    public static function body_class($classes, $args = '') {
        //Do stuff!
        return $classes;
    }


    /**
     * Registers any sidebars that need to be used with the theme.
     *
     * Used by action hook: 'widget_init'
     */
    public static function sidebars() {

        register_sidebar(array(
            'name'          => __( 'Blog Sidebar', 'nvLangScope' ),
            'id'            => 'sidebar-1',
            'description'   => __( 'Drag widgets for Blog sidebar here. These widgets will only appear on the blog portion of your site.', 'nvLangScope' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => "</aside>",
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
        register_sidebar(array(
            'name'          => __( 'Site Sidebar', 'nvLangScope' ),
            'id'            => 'sidebar-2',
            'description'   => __( 'Drag widgets for the Site sidebar here. These widgets will only appear on non-blog pages.', 'nvLangScope' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => "</aside>",
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
        register_sidebar(array(
            'name'          => __( 'Footer', 'nvLangScope' ),
            'id'            => 'sidebar-3',
            'description'   => __( 'Drag footer widgets here.', 'nvLangScope' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => "</aside>",
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }


}