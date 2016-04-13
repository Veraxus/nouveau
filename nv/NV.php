<?php
/** The \NV\Theme\Hooks\NV class */

namespace NV\Theme;

/**
 * This class initializes the NOUVEAU framework via singleton. To fetch the instance, use Nv::get();
 */
class NV {

	/** @var self Stores the singleton instance */
	private static $instance;

	/** @var object An object containing important theme directory paths */
	public $path;
	
	/** @var object An object containing important theme urls */
	public $url;
	
	/** @var int The max width to pass to WordPress' content editor */
	public $content_width = 1200;
	
	/**
	 * Initialize the NV class.
	 */
	protected function __construct() {
		$this->set_properties();
		$this->autoload();
		$this->hooks();
	}

	/**
	 * Initializes default hooks
	 */
	protected function hooks() {
		
		// Setup general theme options
		add_action( 'after_setup_theme', array( '\NV\Theme\Hooks\Config', 'after_setup_theme' ) );

		// Load styles and scripts
		add_action( 'wp_enqueue_scripts', array( '\NV\Theme\Hooks\Config', 'enqueue_assets' ) );

		// Load styles and scripts
		add_action( 'admin_enqueue_scripts', array( '\NV\Theme\Hooks\Config', 'enqueue_admin_assets' ) );

		// Register sidebars
		add_action( 'widgets_init', array( '\NV\Theme\Hooks\Config', 'sidebars' ) );

		// Any customizations to the body_class() function
		add_filter( 'body_class', array( '\NV\Theme\Hooks\Config', 'body_class' ) );

		// Change WordPress' .sticky css class to .stickied to prevent conflict with Foundation
		add_filter( 'post_class', array( '\NV\Theme\Hooks\Config', 'sticky_post_class' ) );


		/** THEME CUSTOMIZATION *******************************************************/

		// Setup the theme customizer options
		add_action( 'customize_register', array( '\NV\Theme\Hooks\ThemeCustomize', 'register' ) );

		// Load the customized style data on the frontend
		add_action( 'wp_head', array( '\NV\Theme\Hooks\ThemeCustomize', 'header_output' ) );

		// Load any javascript needed for live preview updates
		add_action( 'customize_preview_init', array( '\NV\Theme\Hooks\ThemeCustomize', 'live_preview' ) );


		/** INTEGRATE THEME WITH TINYMCE EDITOR **************************************/

		// Adds custom stylesheet to the editor window so styling preview is accurate ( can also use add_editor_style() )
		add_filter( 'mce_css', array( '\NV\Theme\Hooks\Editor', 'style' ) );

		// Add a new "Styles" dropdown to the TinyMCE editor toolbar
		add_filter( 'mce_buttons_2', array( '\NV\Theme\Hooks\Editor', 'buttons' ) );

		// Populate our new "Styles" dropdown with options/content
		add_filter( 'tiny_mce_before_init', array( '\NV\Theme\Hooks\Editor', 'settings_advanced' ) );
	}

	/**
	 * Defines constants any globals needed for the theme
	 */
	protected function set_properties() {

		$this->path         = new \stdClass;
		$this->path->theme  = trailingslashit( get_template_directory() );
		$this->path->lib    = trailingslashit( dirname( __FILE__ ) );
		$this->path->bower  = $this->path->theme . 'bower_components/';
		$this->path->custom = $this->path->lib . 'Custom/';
		$this->path->hooks  = $this->path->lib . 'Hooks/';
		$this->path->utils  = $this->path->lib . 'Utilities/';
		$this->path->parts  = $this->path->theme . 'parts/';
		$this->path->assets = $this->path->theme . 'assets/';
		$this->path->img    = $this->path->assets . 'img/';
		$this->path->langs  = $this->path->assets . 'languages/';

		$this->url          = new \stdClass;
		$this->url->theme   = trailingslashit( get_template_directory_uri() );
		$this->url->bower   = $this->url->theme . 'bower_components/';
		$this->url->assets  = $this->url->theme . 'assets/';
		$this->url->img     = $this->url->assets . 'images/';
		$this->url->css     = $this->url->assets . 'css/';
		$this->url->js      = $this->url->assets . 'js/';

		if ( ! isset( $GLOBALS['content_width'] ) ) {
			$GLOBALS['content_width'] = $this->content_width;
		}
	}

	/**
	 * Gets a theme system path from the path property object.
	 *
	 * @param string $prop   Which sub-property to fetch. Defaults to 'theme'.
	 * @param string $append Optional. Any string data, such as a file, to append to the returned path.
	 *
	 * @return string The requested theme system path
	 * @throws \Exception if property is not found
	 */
	public function get_path( $prop = 'theme', $append = '' ) {
		return $this->get_prop( 'path', $prop ) . $append;
	}

	/**
	 * Gets a theme URL from the 'url' property object.
	 *
	 * @param string $prop   Which sub-property to fetch. Defaults to 'theme'.
	 * @param string $append Optional. Any string data, such as a file, to append to the returned url.
	 *
	 * @return string The requested theme URL
	 * @throws \Exception if property is not found
	 */
	public function get_url( $prop = 'theme', $append = '' ) {
		return $this->get_prop( 'url', $prop ) . $append;
	}

	/**
	 * Returns a class property.
	 *
	 * @param string      $prop    The property value to retrieve
	 * @param string|bool $subProp The sub-property value to retrieve
	 *
	 * @return mixed
	 * @throws \Exception if property is not found
	 */
	public function get_prop( $prop, $subProp = false ) {

		if ( ! isset( $this->$prop ) ) {
			throw new \Exception( "get_prop() could not find \$this->{$prop} in " . __CLASS__ );
		}

		if ( $subProp && isset( $this->$prop->$subProp ) ) {
			return $this->$prop->$subProp;
		}

		throw new \Exception( "get_prop() could not find \$this->{$prop}->{$subProp} in " . __CLASS__ );
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
				$base_dir = $this->path->lib;

				// does the class use the namespace prefix?
				$len = strlen( $prefix );
				if ( strncmp( $prefix, $class, $len ) !== 0 ) {
					// no, move to the next registered autoloader
					return;
				}

				// get the relative class name
				$relative_class = substr( $class, $len );

				// replace the namespace prefix with the base directory, replace namespace
				// separators with directory separators in the relative class name, append
				// with .php
				$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

				// if the file exists, require it
				if ( file_exists( $file ) ) {
					require $file;
				}
			}
		);

	}

	/**
	 * Singleton for accessing the Nv instance.
	 *
	 * @return self
	 */
	public static function i() {
		if ( self::$instance === null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}

NV::i();
