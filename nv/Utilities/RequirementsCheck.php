<?php
/** The \NV\Theme\Utilities\RequirementsCheck class */

namespace NV\Theme\Utilities;

/**
 * Instantiate this class to check 
 */
class RequirementsCheck {
	
	/** @var string Set the version of WordPress required */
	public $required_wp = '4.5';

	/** @var string Set the version of PHP required */
	public $required_php = '5.4';

	/** @var bool Stores requirements check result. true if pass, false if fail. */
	public $is_compatible;

	/** @var string The validation message to display if check fails. */
	public $errors;

	/**
	 * RequirementsCheck constructor.
	 *
	 * @param string $required_php Provide version as string to set required php version
	 * @param string $required_wp Provide version as string to set required WordPress version
	 */
	function __construct( $required_php = null, $required_wp = null ) {
		
		// If php req is set, use it
		if ( $required_php ) {
			$this->required_php = $required_php;
		}

		// If wp req is set, use it
		if ( $required_wp ) {
			$this->required_wp = $required_wp;
		}

		//Run check and save result to $this->is_compatible
		$this->check_requirements();

		//Set compatibility based on errors
		$this->is_compatible = ( count( $this->errors ) === 0 );

		//If check fails, run notification hooks
		if ( ! $this->is_compatible ) {
			//Check front end
			$this->display_frontend_error();
			// Perform check on admin
			add_action( 'admin_notices', array( &$this, 'check_for_admin' ) );
		}

	}


	/**
	 * Checks the current version of PHP
	 *
	 * @param string $req_php The required version of PHP
	 * @param string $req_wp  The required version of WordPress
	 *
	 * @return boolean True if users version is >= required version
	 */
	public function check_requirements() {
		global $wp_version;

		//VALIDATE PHP VERSION
		if ( version_compare( PHP_VERSION, $this->required_php, '<' ) ) {
			//Set the default error message
			$this->errors['php'] = sprintf(
				__( '<p><b>WARNING:</b> This theme requires PHP %s or newer! Your server is currently running PHP %s; it will not work until PHP is updated. <a href="%s">Change theme?</a></p>', 'nvLangScope' ),
				$this->required_php,
				PHP_VERSION,
				admin_url( 'themes.php' )
			);
		}

		//VALIDATE WP VERSION
		if ( version_compare( $wp_version, $this->required_wp, '<' ) ) {
			//Set the default error message
			$this->errors['wp'] = sprintf(
				__( '<p><b>WARNING:</b> This theme requires WordPress %s or newer! You are currently running WordPress %s; it will not work until WordPress is updated. <a href="%s">Change theme?</a></p>', 'nvLangScope' ),
				$this->required_wp,
				$wp_version,
				admin_url( 'themes.php' )
			);
		}

	}

	/**
	 * This DRYs the process of displaying an admin message. Special note: only call this inside any function that is
	 * already hooked by 'admin_notices'
	 *
	 * @param string $message The message you want to display.
	 * @param string $type    This can be either 'notice' (default) or 'error'.
	 */
	public function show_admin_error( $message, $type = 'notice' ) {
		$html['notice'] = '<div class="updated">%s</div>';
		$html['error']  = '<div class="error">%s</div>';
		printf( $html[$type], $message );
	}


	/**
	 * Generally, you shouldn't call this method directly. Instead, use:
	 *
	 * add_action( 'admin_notices', array( &$this, 'show_admin_error' )
	 *
	 * This will show a message on the WordPress admin if the minimum requirements are not met. This gives admins the
	 * ability to shut down the theme if needed by not breaking the admin.
	 */
	public function check_for_admin() {
		if ( ! $this->check_requirements() ) {
			$this->show_admin_error( $this->get_errors(), 'error' );
		}
	}


	/**
	 * Completely stops execution and displays an error on the site's frontend. This won't run on admin so that admins
	 * won't get locked out of their sites.
	 */
	public function display_frontend_error() {
		if ( ! $this->is_compatible && ! is_admin() && ! $this->is_login() ) {
			wp_die( $this->get_errors() );
		}
	}


	/**
	 * Fetches errors as a string
	 * 
	 * @return string All errors as a string.
	 */
	public function get_errors() {
		return implode( '', $this->errors );
	}


	/**
	 * Detects whether this is the login page
	 *
	 * @return boolean True if this is the login page
	 */
	protected function is_login() {
		return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
	}

}