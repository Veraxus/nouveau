<?php
/**
 * This file is only included as an example and an accelerated starting point for custom WordPress admin pages. To
 * make this page visible in the admin, uncomment the add_theme_page() entry in NV\hooks\Admin::menus()
 *
 * We do NOT recommend using this for theme options pages. Instead, you should use WordPress's Theme Customizer.
 *
 * For Nouveau, we've elected to NOT use the Settings API as hand-crafted pages allow for more control over
 * presentation and interactivity. If you would prefer to use the Settings API, a starting point is available
 * in \NV\Hooks\Admin::settings_api();
 *
 * Help text that you would like to make available in the WordPress admin for this page (and all other custom help
 * text) should be defined in nv\hooks\Admin::help()
 *
 * All code processing should occur in this file before any presentational code. This file can be loaded by using a
 * closure as your callback and requiring this file.
 *
 * If you need to define default values for your theme options, you should do so from \NV\Hooks\Theme::features()
 *
 * @deprecated This is being removed from NOUVEAU, but will live on as a plugin.
 * @see \NV\Hooks\Admin::menu()
 * @see \NV\Hooks\Admin::help()
 * @see \NV\Hooks\General::features()
 */

$message = false;

if ( isset($_REQUEST['action']) && 'update' === $_REQUEST['action'] ) {
    if ( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'examplepage_nonce' ) || !current_user_can( 'manage_options' ) ) {
        wp_die( __( 'Cheatin&#8217; uh?' ) );
    }

    //START SAVE
    update_option( 'nouveau_example_checkbox', isset($_REQUEST['nouveau_example_checkbox']) );
    update_option( 'nouveau_example_radio', isset($_REQUEST['nouveau_example_radio']) );
    update_option( 'nouveau_example_text', isset($_REQUEST['nouveau_example_text']) );
    update_option( 'nouveau_example_select', isset($_REQUEST['nouveau_example_select']) );
    //END SAVE

    $message = 'updated';

}
/* == BEGIN TEMPLATE OUTPUT ========================================================================================= */
?>
<!-- see example.code.php for handler code and documentation -->
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br></div><h2><?php _e( 'Example Admin Page', 'nvLangScope' ) ?></h2>

    <!-- message controls -->
    <?php 
    switch( $message ) {
        case 'updated':
            printf( '<div id="message" class="updated below-h2"><p>%s</p></div>' , __( 'Settings saved.','nvLangScope' ) );
        break;
    
        default:break;
    }
    ?>
    <!-- /message controls -->

    <p><?php printf( __( 'This page can be customized by editing the files under <code>%s/</code> in your theme directory.', 'nvLangScope' ), preg_replace( '|'.preg_quote( NV_PATH ).'|', '', dirname( __FILE__ ) ) ); ?></p>
    <p><?php _e( 'If you need to include a list table on this page, please refer to <a href="http://codex.wordpress.org/Class_Reference/WP_List_Table">this WordPress codex entry</a> and the <a href="http://wordpress.org/extend/plugins/custom-list-table-example/">Custom List Table Example plugin</a>.', 'nvLangScope' ) ?></p>
    <p><?php _e( 'This whole page can be disabled from <code>\NV\Hooks\Admin::menus()</code>', 'nvLangScope' ) ?></p>
    
    <form action="options.php" method="post">
        
        <?php wp_nonce_field( 'examplepage_nonce' ); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="nouveau_example_checkbox"><?php _e( 'Example checkbox', 'nvLangScope' ) ?></label>
                </th>
                <td>
                    <input type="checkbox" name="nouveau_example_checkbox" id="nouveau_example_checkbox" <?php checked( get_option( 'nouveau_example_checkbox', false ) ) ?> /> <label for="nouveau_example_checkbox"><?php _e( 'This is an example checkbox (unchecked by default)', 'nvLangScope' ) ?></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="nouveau_example_radio[]"><?php _e( 'Example Radio', 'nvLangScope' ) ?></label>
                </th>
                <td>
                    <input type="radio" name="nouveau_example_radio[]" id="nouveau_example_radio_1" value="1" <?php checked(get_option('nouveau_example_radio',1),1) ?> /> <label for="nouveau_example_radio_1"><?php _e('Radio button with a value of','nvLangScope') ?> 1</label><br/>
                    <input type="radio" name="nouveau_example_radio[]" id="nouveau_example_radio_2" value="2" <?php checked(get_option('nouveau_example_radio',1),2) ?> /> <label for="nouveau_example_radio_2"><?php _e('Radio button with a value of','nvLangScope') ?> 2</label><br/>
                    <input type="radio" name="nouveau_example_radio[]" id="nouveau_example_radio_3" value="3" <?php checked(get_option('nouveau_example_radio',1),3) ?> /> <label for="nouveau_example_radio_3"><?php _e('Radio button with a value of','nvLangScope') ?> 3</label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="nouveau_example_text"><?php _e('Example Text','nvLangScope') ?></label>
                </th>
                <td>
                    <input type="text" name="nouveau_example_text" id="nouveau_example_text" value="<?php echo get_option('nouveau_example_text') ?>" />
                    <p class="description"><?php _e('This field is empty by default. To set a default value, see the method <code>\NV\Hooks\General::features()</code>','nvLangScope') ?></p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="nouveau_example_select"><?php _e('Example Select','nvLangScope') ?></label>
                </th>
                <td>
                    <select name="nouveau_example_select" id="nouveau_example_select">
                        <option value="1" <?php selected(get_option('nouveau_example_select',1),1) ?>><?php _e('Select option with a value of','nvLangScope') ?> 1</option>
                        <option value="2" <?php selected(get_option('nouveau_example_select',1),2) ?>><?php _e('Select option with a value of','nvLangScope') ?> 2</option>
                        <option value="3" <?php selected(get_option('nouveau_example_select',1),3) ?>><?php _e('Select option with a value of','nvLangScope') ?> 3</option>
                    </select>
                </td>
            </tr>
        </table>
        
        <p><button name="submit" type="submit" class="button-primary"><?php _e('Save Changes', 'nvLangScope'); ?></button></p>
        
    </form>
    
</div>