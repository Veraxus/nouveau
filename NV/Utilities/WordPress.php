<?php
/** The \NV\Theme\Utilities\WordPress class */

namespace NV\Theme\Utilities;

/**
 * This class provides WordPress-oriented methods that are not included in WordPress core by default (or were not at
 * the time of this writing).
 */
class WordPress {

	/**
	 * Remove post types. This should only be called from within the 'init'
	 * action hook.
	 *
	 * @global array $wp_post_types
	 *
	 * @param string $post_type
	 *
	 * @return boolean Returns true if post type was found and removed.
	 */
	public static function unregister_post_type( $post_type ) {
		global $wp_post_types;

		if ( isset( $wp_post_types[$post_type] ) ) {
			unset( $wp_post_types[$post_type] );

			return true;
		}

		return false;
	}


	/**
	 * Remove a registered taxonomy from an object type
	 *
	 * @global array $wp_taxonomies
	 *
	 * @param string $taxonomy
	 * @param string $object_type
	 *
	 * @return boolean True if successful, false if not
	 */
	public static function unregister_taxonomy( $taxonomy, $object_type ) {
		global $wp_taxonomies;

		if ( ! isset( $wp_taxonomies[$taxonomy] ) ) {
			return false;
		}

		if ( ! get_post_type_object( $object_type ) ) {
			return false;
		}

		foreach ( array_keys( $wp_taxonomies['category']->object_type ) as $array_key ) {
			if ( $object_type == $wp_taxonomies['category']->object_type[$array_key] ) {
				unset ( $wp_taxonomies['category']->object_type[$array_key] );

				return true;
			}
		}

		return false;

	}

	/**
	 * Checks whether a page is a taxonomy archive (of ANY type). This is more broad than WordPress' built-in is_tax()
	 * since this considers both 'tag' and 'category' to be general taxonomies.
	 *
	 * @return boolean True is the current page is a taxonomy archive of any type.
	 */
	public static function is_tax_archive() {
		return ( is_tax() || is_category() || is_tag() );
	}

	/**
	 * Checks whether a page is is a post archive. Unlike WordPress' built-in is_post_type_archive() function,
	 * this returns true for the built-in 'post' archive / home.
	 *
	 * @return boolean True is the current page is a post archive of any type.
	 */
	public static function is_post_type_archive() {
		return ( is_post_type_archive() || is_home() );
	}


	/**
	 * Gets the options for a widget of the specified name.
	 *
	 * @param string $widget_id Optional. If provided, will only get options for the specified widget.
	 * @param string $option    Optional. If provided with $name, will return only the requested option for the requested widget.
	 * @param mixed  $default   Optional. If provided, use this value if the option is empty.
	 *
	 * @return array An associative array containing the widget's options and values. False if no widget opts found.
	 */
	public static function get_dashboard_widget_options( $widget_id = '', $option = '', $default = false ) {
		//Fetch ALL dashboard widget options from the db...
		$opts = get_option( 'dashboard_widget_options' );

		//If the widget we're requesting is empty, return false.
		if ( ! empty( $widget_id ) && empty( $opts[$widget_id] ) ) {
			return false;
		}

		//If a specific widget is requested, narrow down to selection to that widget (if it exists)
		if ( ! empty( $widget_id ) ) {
			$wopts = $opts[$widget_id]; //Narrow down the selection to our specific widget

			if ( ! empty( $option ) ) //If we've requested a specific option...
			{
				if ( ! isset( $wopts[$option] ) ) //If that option doesn't exist...
				{
					if ( $default !== false ) //If we set a default value...
					{
						return $default; //Return the set default value.
					}

					return false; //No default set. Return false.
				}

				return $wopts[$option]; //If all is well, return the option
			}
		}

		//Failing all else, return all the options.
		return $opts;
	}

	/**
	 * Outputs the permalink for the current or specified page. Identical to WordPress's built-in the_permalink() except
	 * this allows you to specify a specific post id.
	 *
	 * @param int $id
	 */
	public static function the_permalink( $id = 0 ) {
		echo esc_url( apply_filters( 'the_permalink', get_permalink( $id ) ) );
	}

	/**
	 * Saves a single option for a single dashboard widget to the database.
	 *
	 * @param string $widget_id The name of the widget being updated
	 * @param string $option    The name of the option being saved
	 * @param mixed  $value     The value of the option being saved.
	 * @param bool   $delete
	 *
	 * @return bool
	 */
	public static function update_dashboard_widget_option( $widget_id, $option, $value, $delete = false ) {
		$opts = get_option( 'dashboard_widget_options' ); //Fetch ALL dashboard widget options from the db...

		if ( $delete && isset( $opts[$widget_id][$option] ) ) //If we're deleting an option...
		{
			unset( $opts[$widget_id][$option] );
		} else {
			$opts[$widget_id][$option] = $value; //Merge new options with existing ones, and add it back to the widgets array
		}

		return update_option( 'dashboard_widget_options', $opts ); //Save the entire widgets array back to the db
	}

	/**
	 * Saves an array of options for a single dashboard widget to the database. Can also be used to define default
	 * values for a widget.
	 *
	 * @param string $widget_id The name of the widget being updated
	 * @param array  $args      An associative array of options being saved.
	 *
	 * @return bool
	 */
	public static function update_dashboard_widget_options( $widget_id, $args = [] ) {
		$opts = get_option( 'dashboard_widget_options' ); //Fetch ALL dashboard widget options from the db...

		$w_opts = $opts[$widget_id] ?: []; //Get just our widget's options, or set empty array

		$opts[$widget_id] = array_merge( $w_opts, $args ); //Merge new options with existing ones, and add it back to the widgets array

		return update_option( 'dashboard_widget_options', $opts ); //Save the entire widgets array back to the db
	}


}