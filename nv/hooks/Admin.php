<?php
namespace NV\Hooks;

use NV\Html;

/**
 * @deprecated
 */
class Admin {


    /**
     * If you would like to use the Settings API, this is the place to put your code. If you have a lot of settings, you
     * may want to split things out into separate methods. I recommend going with settings_yourname() in this same
     * class, and then simply calling those methods from within this one.
     *
     * Personally, I'm not a fan of the settings API since I like to have more control over how the settings are
     * presented and organized.
     *
     * Read more here: http://codex.wordpress.org/Settings_API
     *
     * @see add_action('admin_init',$func)
     * @since Nouveau 1.0
     */
    public static function settings_api() {

        // 1. Create a setting in the database
        //register_setting($option_group, $option_name, $sanitize_callback);

        // 2. Create a setting "section" for organization
        //add_settings_section($id, $title, $callback, $page);

        // 3. Add a visible HTML control/field
        //add_settings_field($id, $title, $callback, $page, $section, $args);

    }

    /**
     * Customizes help text for the admin.
     *
     * {{{
     * wp_die( '<pre>'.print_r($current_screen,true).'</pre>' );
     * }}}
     *
     * Used by hook: admin_head
     *
     * @see add_action('admin_head',$func)
     * @global WP_Screen $current_screen Information about the current admin screen
     * @since Nouveau 1.0
     */
    public static function help() {

        global $wp_meta_boxes;
        $current_screen = get_current_screen();

        //Add new help text
        switch ( $current_screen->id ) {

            //Add an example help text to the 'edit page' screen
            /*
            case 'edit-page':
                get_current_screen()->remove_help_tabs();
                get_current_screen()->add_help_tab( array(
                    'id'      => 'example',
                    'title'   => __('Example','nvLangScope'),
                    'content' => '<p>Example</p>',
                ) );
            break;
            */

            default:
                break;
        }

        // IF WP_DEBUG IS TRUE, OUTPUT SOME STUFF TO HELP MENU
        if ( WP_DEBUG ) {
            //Add current screen object to the help tab
            get_current_screen()->add_help_tab( array(
                'id'      => 'screen-object',
                'title'   => __( 'Dev: Screen Object', 'nvLangScope' ),
                'content' => '<p>' . __( 'This tab shows the current admin screen object. To disable this tab, simply edit <tt>wp-config.php</tt> and set constant <tt>WP_DEBUG</tt> equal to <tt>FALSE</tt>', 'nvLangScope' ) . '</p><hr/><p><pre>' . htmlspecialchars( print_r( get_current_screen(), true ) ) . '</pre></p>',
            ) );

            //Add current screen object to the help tab
            get_current_screen()->add_help_tab( array(
                'id'      => 'meta-boxes',
                'title'   => __( 'Dev: Meta Boxes', 'nvLangScope' ),
                'content' => '<p><pre>' . htmlspecialchars( print_r( $wp_meta_boxes, true ) ) . '</pre></p>',
            ) );

        }

        // IF DEBUG BAR + DEBUG BAR EXTENDER IS INSTALLED, OUTPUT TO DEBUG BAR
        if ( class_exists( 'Debug_Bar_Extender' ) ) {

            if ( ! empty( $current_screen ) ) {
                \Debug_Bar_Extender::instance()->trace_var( $current_screen );
            }

            if ( ! empty( $wp_meta_boxes ) ) {
                \Debug_Bar_Extender::instance()->trace_var( $wp_meta_boxes );
            }

        }

    }


}