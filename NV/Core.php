<?php
/** The \NV\Theme\Customize\NV class */

namespace NV\Theme;

/**
 * This class initializes the NOUVEAU framework via singleton. To fetch the instance, use Nv::get();
 */
class Core {

	/** @var Core Stores the singleton instance */
	private static $instance;

	/** @var object An object containing important theme directory paths */
	public $paths;

	/** @var object An object containing important theme urls */
	public $urls;

	/** @var int The max width of content */
	public $content_width = 1200;
	

	/**
	 * Initializes default hooks
	 */
	protected function hooks() {

		// Setup general theme options
		add_action( 'after_setup_theme', [ '\NV\Theme\Customize\Config', 'after_setup_theme' ] );

		// Load styles and scripts
		add_action( 'wp_enqueue_scripts', [ '\NV\Theme\Customize\Config', 'enqueue_assets' ] );

		// Load styles and scripts
		add_action( 'admin_enqueue_scripts', [ '\NV\Theme\Customize\Config', 'enqueue_admin_assets' ] );

		// Register sidebars
		add_action( 'widgets_init', [ '\NV\Theme\Customize\Config', 'sidebars' ] );

		// Any customizations to the body_class() function
		add_filter( 'body_class', [ '\NV\Theme\Customize\Config', 'body_class' ] );

		// Change WordPress' .sticky css class to .stickied to prevent conflict with Foundation
		add_filter( 'post_class', [ '\NV\Theme\Customize\Config', 'sticky_post_class' ] );


		/** THEME CUSTOMIZATION *******************************************************/

		// Setup the theme customizer options
		add_action( 'customize_register', [ '\NV\Theme\Customize\ThemeCustomizer', 'register' ] );

		// Load the customized style data on the frontend
		add_action( 'wp_head', [ '\NV\Theme\Customize\ThemeCustomizer', 'header_output' ] );

		// Load any javascript needed for live preview updates
		add_action( 'customize_preview_init', [ '\NV\Theme\Customize\ThemeCustomizer', 'live_preview' ] );


		/** INTEGRATE THEME WITH TINYMCE EDITOR **************************************/

		// Adds custom stylesheet to the editor window so styling preview is accurate ( can also use add_editor_style() )
		add_filter( 'mce_css', [ '\NV\Theme\Customize\Editor', 'style' ] );

		// Add a new "Styles" dropdown to the TinyMCE editor toolbar
		add_filter( 'mce_buttons_2', [ '\NV\Theme\Customize\Editor', 'buttons' ] );

		// Populate our new "Styles" dropdown with options/content
		add_filter( 'tiny_mce_before_init', [ '\NV\Theme\Customize\Editor', 'settings_advanced' ] );
	}
	

	/**
	 * Returns JS enqueue path based on WP_DEBUG setting. If WP_DEBUG is true, the src version will be used, otherwise
	 * the minified version will be used. Assumes src files are in /assets/js/src/ and min files are in /assets/js/
	 *
	 * @param string $filename The minified filename to process
	 * @param string $path     The url path to pass to get_url(), defaults to 'js'
	 *
	 * @return string Returns
	 */
	public function get_js_url( $filename, $path = 'js' ) {

		// Use theme's src js if debug is true
		if ( WP_DEBUG && 'js' === $path ) {
			// Strip the .min
			$filename = str_replace( '.min.js', '.js', $filename );
			// Add the src directory
			//$filename = preg_replace( '|([^/]+).js$|', 'src/$1.js', $filename );
		}

		return $this->urls->$path . $filename;
	}


	/**
	 * Returns the plugin's root namespace path, or prepends the plugin namespace(s) to the provided classname string.
	 *
	 * @param string $class The fully qualified class name
	 *
	 * @return string
	 */
	public function get_ns( $class = '' ) {
		return '\\' . __NAMESPACE__ . '\\' . $class;
	}
	

	/**
	 * Registers a PSR-4 compliant class autoloader.
	 */
	protected function autoload() {

		spl_autoload_register(
			function ( $class ) {
				// project-specific namespace prefix
				$prefix = __NAMESPACE__ . '\\';

				// base directory for the namespace prefix
				$base_dir = trailingslashit( dirname( __FILE__ ) );

				// does the class use the namespace prefix?
				$len = strlen( $prefix );
				if ( strncmp( $prefix, $class, $len ) !== 0 ) {
					// no, move to the next registered autoloader
					return;
				}

				// get the relative class name
				$relative_class = substr( $class, $len );

				// replace the namespace prefix with the base directory, replace namespace separators with directory
				// separators in the relative class name, append with .php
				$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

				// if the file exists, require it
				if ( file_exists( $file ) ) {
					require $file;
				}
			}
		);

	}
	

	/**
	 * Initialize the class.
	 * 
	 * This is lower in the class since it's unlikely you'll need to customize it.
	 */
	protected function __construct() {

		// Initialize the autoloader
		$this->autoload();

		// Get important system paths for theme
		$this->paths = new Bootstrap\Paths( __FILE__ );

		// Get important urls for theme
		$this->urls  = new Bootstrap\Urls();

		// Set WP content width global
		if ( ! isset( $GLOBALS['content_width'] ) ) {
			$GLOBALS['content_width'] = $this->content_width;
		}

		// Register all theme hooks
		$this->hooks();
	}
	

	/**
	 * Singleton for accessing the Nv instance.
	 *
	 * @return Core
	 */
	public static function i() {
		if ( self::$instance === null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

Core::i();
