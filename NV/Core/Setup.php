<?php

namespace NV\Theme\Core;

use NV\Theme\Core;

/**
 * Contains functions for reconfiguring the admin back-end. Generally, method names should match the hook name for
 * easy identification. In cases where a generic hook is utilized, a more logical method name should be used.
 */
class Setup
{

    /**
     * Sets up basic theme features.
     *
     * @hook action 'after_setup_theme'
     *
     * @see https://developer.wordpress.org/reference/hooks/after_setup_theme/
     *
     * @uses self::languages();
     */
    public static function after_setup_theme()
    {

        // Load available language pack
        load_theme_textdomain('nv_lang_scope', Core::i()->paths->langs);

        // Let WordPress generate the <title> tag for you
        add_theme_support('title-tag');

        // Let WordPress automatically generate RSS feed urls
        add_theme_support('automatic-feed-links');

        // Enable HTML5 support
        add_theme_support('html5',
            [
                'comment-list',
                'comment-form',
                'search-form',
                'gallery',
                'caption',
            ]
        );

        // Add custom header support
        add_theme_support(
            'custom-header',
            [
                'width'                  => 1200,
                'height'                 => 250,
                'flex-height'            => true,
                'flex-width'             => true,
                'default-image'          => Core::i()->urls->img('header.gif'),
                'random-default'         => false,
                'header-text'            => true,
                'default-text-color'     => '',
                'uploads'                => true,
                'wp-head-callback'       => null,
                'admin-head-callback'    => null,
                'admin-preview-callback' => null,
            ]
        );

        // Core your background
        add_theme_support(
            'custom-background',
            [
                'default-image'          => '',
                'default-repeat'         => 'repeat',
                'default-position-x'     => 'left',
                'default-attachment'     => 'scroll',
                'default-color'          => '',
                //'wp-head-callback'       => '_custom_background_cb',
                'admin-head-callback'    => '',
                'admin-preview-callback' => '',
            ]
        );

        // Enable support for blog post thumbnails
        add_theme_support('post-thumbnails');

        // Enable support for post formats
        add_theme_support(
            'post-formats',
            [
                'aside',
                'audio',
                'chat',
                'gallery',
                'image',
                'link',
                'quote',
                'status',
                'video',
            ]
        );

        // Enable support for WooCommerce
        add_theme_support('woocommerce');

        // Register your default navigation
        register_nav_menu('primary', __('Primary Menu', 'nv_lang_scope'));
        register_nav_menu('footer', __('Footer Menu', 'nv_lang_scope'));

        /*
         * Set up any default values needed for theme options. If a default value is needed, it can be provided as a
         * second parameter. This will NOT overwrite any existing options with these names.
         */
//		add_option( 'nouveau_example_checkbox' );
//		add_option( 'nouveau_example_radio' );
//		add_option( 'nouveau_example_text', 'This is example default text.' );
//		add_option( 'nouveau_example_select' );

    }


    /**
     * Enqueues styles and scripts.
     *
     * The copies of foundation, jquery, and what-input that included are moved into assets/dist/js by the Gulp task
     * build:scripts to ensure those scripts are available even if node_modules is not present.
     *
     * @hook action 'wp_enqueue_scripts'
     *
     * @see https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
     */
    public static function enqueue_assets()
    {

        // =================================
        // ENQUEUE STYLES
        // =================================

        // Base stylesheet (compiled Foundation SASS)
        wp_enqueue_style('app', Core::i()->urls->css('app.css'));

        // WordPress's required styles.css
        wp_enqueue_style('styles', get_bloginfo('stylesheet_url'), ['app']);


        // =================================
        // ENQUEUE SCRIPTS
        // =================================

        // Remove WordPress's jQuery...
        wp_deregister_script('jquery');

        // Add our own jQuery
        wp_enqueue_script(
            'jquery',
            Core::i()->urls->get_js('jquery.min.js'),
            [],
            false,
            true
        );

        // Foundation what-input dependency
        wp_enqueue_script(
            'what-input',
            Core::i()->urls->get_js('what-input.min.js'),
            [],
            false,
            true
        );

        // Load the complete version of Foundation
        wp_enqueue_script(
            'foundation',
            Core::i()->urls->get_js('foundation.min.js'),
            ['jquery', 'what-input'],
            false,
            true
        );

        // Load any custom javascript (remember to update dependencies if you changed the above)...
        wp_enqueue_script(
            'nv-theme',
            Core::i()->urls->get_js('app.min.js'),
            ['foundation'],
            false,
            true
        );

    }


    /**
     * Enqueues styles and scripts for the admin section
     *
     * Used by action hook: 'admin_enqueue_scripts'
     *
     * @see https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
     */
    public static function enqueue_admin_assets()
    {

        // Base admin styles
        wp_enqueue_style('nv-admin', Core::i()->urls->css('admin.css'));

        // Base admin scripts
        wp_enqueue_script('nv-admin', Core::i()->urls->get_js('admin.min.js'), ['jquery'], false, false);
    }


    /**
     * Allows customization of classes output to the <body> element via WordPress' body_class() function.
     *
     * Used by filter hook: 'body_class'
     *
     * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
     *
     * @param array $classes
     * @return array The proccesses classes array
     */
    public static function body_class($classes)
    {
        //Do stuff!
        return $classes;
    }


    /**
     * Registers any sidebars that need to be used with the theme.
     *
     * Used by action hook: 'widgets_init'
     *
     * @see https://developer.wordpress.org/reference/hooks/widgets_init/
     */
    public static function sidebars()
    {

        register_sidebar(
            [
                'name'          => __('Blog Sidebar', 'nv_lang_scope'),
                'id'            => 'sidebar-1',
                'description'   => __('Drag widgets for Blog sidebar here. These widgets will only appear on the blog portion of your site.',
                    'nv_lang_scope'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => "</aside>",
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ]
        );
        register_sidebar(
            [
                'name'          => __('Site Sidebar', 'nv_lang_scope'),
                'id'            => 'sidebar-2',
                'description'   => __('Drag widgets for the Site sidebar here. These widgets will only appear on non-blog pages.',
                    'nv_lang_scope'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => "</aside>",
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ]
        );
        register_sidebar(
            [
                'name'          => __('Footer', 'nv_lang_scope'),
                'id'            => 'sidebar-3',
                'description'   => __('Drag footer widgets here.', 'nv_lang_scope'),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => "</aside>",
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ]
        );
    }


    /**
     * Renames WordPress' default .sticky class to .status-sticky to prevent conflicts with Foundation.
     *
     * By default, Foundation uses the .sticky class to "stick" content to the top of the screen when scrolling below
     * the top of the window.
     *
     * Used by action hook: post_class
     *
     * @see https://developer.wordpress.org/reference/hooks/post_class/
     *
     * @param array $classes An array of classes for each post
     *
     * @return array
     */
    public static function sticky_post_class($classes)
    {
        if (in_array('sticky', $classes)) {
            $classes   = array_diff($classes, ['sticky']);
            $classes[] = 'status-sticky';
        }
        return $classes;
    }

    /**
     * Tells WordPress what the global content width should be.
     *
     * @param int $width The width, in px, of the content
     */
    public static function content_width($width)
    {
        // Set WP content width global
        if (!isset($GLOBALS['content_width'])) {
            $GLOBALS['content_width'] = $width;
        }
    }


}