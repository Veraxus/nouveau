<?php
/** The \NV\Theme\Hooks\ThemeCustomize class */

namespace NV\Theme\Hooks;

use NV\Theme\NV;

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link  http://codex.wordpress.org/Theme_Customization_API
 */
class ThemeCustomize {

	/**
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows you to add new sections and controls to
	 * the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom javascript.
	 *
	 * @used-by add_action( 'customize_register', $func )
	 *
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public static function register( $wp_customize ) {

		/** REGISTER A SETTING IN 3 EASY STEPS... */
		// 1) Define a new section (if desired) to the Theme Customizer
		/*
		$wp_customize->add_section( 'nouveau_theme_options',
		  array(
			  'title'         => __( 'Nouveau Options', 'nvLangScope' ),
			  'priority'      => 35,
			  'capability'    => 'edit_theme_options',
			  'description'   => __('Allows you to customize some example settings for Nouveau.', 'nvLangScope'),
		  )
		);
		*/

		// 2) Register new settings to the WP database...
		$wp_customize->add_setting(
			'nouveau_theme_options[link_textcolor]',    // Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(                                      // Pass an args array...
				'default'    => '#2BA6CB',              // Default setting/value to save
				'type'       => 'option',               // Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options',   // Optional. Special permissions for accessing this setting.
				'transport'  => 'postMessage',          // What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);


		// 3) Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control(
			new \WP_Customize_Color_Control(                                // Instantiate the color control class
				$wp_customize,                                              // Pass the $wp_customize object (required)
				'nouveau_link_textcolor',                                   // Set a unique ID for the control
				array(                                                      // Pass an args array....
					'label'    => __( 'Link Color', 'nvLangScope' ),        // Admin-visible name of the control
					'section'  => 'colors',                                 // ID of the section this control should render in (can be one of yours, or a WordPress default section)
					'settings' => 'nouveau_theme_options[link_textcolor]',  // Which setting to load and manipulate (serialized is okay)
					'priority' => 10,                                       // Determines the order this control appears in for the specified section
				)
			)
		);


		/** OTHER EXAMPLE CONTROL TYPES **/
		// Radio button list...
		/*
		$wp_customize->add_control( 'nouveau_example_radio_list', array(  // Unique id for the control
			'label'     => __( 'Example Radio List', 'nvLangScope' ),     // Admin-visible name of the control
			'section'   => 'nouveau_theme_options',                       // Which pre-defined section does this control go in?
			'settings'  => 'nouveau_theme_options[container_bg_color]',   // What is the serialized name of this option?
			'type'      => 'radio',                                       // What type of control is this? Radio? Checkbox? Select?
			'choices'   => array(                                         // Define an array of choices
				'value1'    => 'Choice 1',                                // Value => Text format
				'value2'    => 'Choice 2',
				'value3'    => 'Choice 3',
			),
			'priority'	=> 10,                                            // Determines the order this control appears in for the specified section
		) );
		*/

		// We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	}


	/**
	 * This will output the custom WordPress settings to the theme's WP head.
	 *
	 * @used-by add_action( 'wp_head', $func )
	 */
	public static function header_output() {
		// If we're not previewing, don't output anything
		if ( ! is_preview() ) {
			return;
		}
		?>
		<!--Customizer CSS-->
		<style type="text/css">
			<?php self::generate_css( '#site-title a', 'color', 'header_textcolor', '#' ); ?>
			<?php self::generate_css( 'body', 'background-color', 'background_color', '#' ); ?>
			<?php self::generate_css( 'a', 'color', 'nouveau_theme_options[link_textcolor]' ); ?>
		</style>
		<!--/Customizer CSS-->
		<?php
	}

	/**
	 * This outputs the javascript needed to automate the live settings preview. Also keep in mind that this function
	 * isn't necessary unless your settings are explicitly using 'transport'=>'postMessage' instead of the default
	 * 'transport' => 'refresh' behavior.
	 *
	 * @used-by add_action( 'customize_preview_init', $func )
	 */
	public static function live_preview() {
		$min = ( WP_DEBUG ) ? '.min' : '';

		wp_enqueue_script(
			'nouveau-themecustomizer', //Give the script an ID
			NV::i()->get_url( 'js', 'theme-customizer' . $min . '.js' ), //Define its JS file
			array( 'jquery', 'customize-preview' ), //Define dependencies
			null, //Define a version (optional)
			true //Specify whether to put in footer (leave this true)
		);
	}

	/**
	 * This will generate a line of CSS for use in header output. If the setting ($mod_name) has no defined value, the
	 * CSS will not be output.
	 *
	 * @uses  get_theme_mod()
	 *
	 * @param string $selector CSS selector
	 * @param string $style    The name of the CSS *property* to modify
	 * @param string $mod_name The name of the 'theme_mod' option to fetch
	 * @param string $prefix   Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix  Optional. Anything that needs to be output after the CSS property
	 * @param bool   $echo     Optional. Whether to print directly to the page (default: true).
	 *
	 * @return string Returns a single line of CSS with selectors and a property.
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
		$return = '';

		$mod = get_theme_mod( $mod_name );

		if ( ! empty( $mod ) ) {
			$return = sprintf(
				'%s { %s:%s; }',
				$selector,
				$style,
				$prefix . $mod . $postfix
			);
			if ( $echo ) {
				echo $return;
			}
		}

		return $return;
	}

}