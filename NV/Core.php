<?php

namespace NV\Theme;

use NV\Theme\Core\Setup;

/**
 * The heart and soul of your theme. Can be accessed via a convenient singleton: Core::i()
 */
class Core
{

    /** @var Core Stores the singleton instance */
    private static $instance;

    /** @var Paths An object containing important theme directory paths */
    public $paths;

    /** @var Urls An object containing important theme urls */
    public $urls;

    /** @var \Monolog\Logger A log object */
    public $log;

    /** @var int The max width of content */
    public $content_width = 1200;


    /**
     * Initializes all the theme's hooks
     *
     * To the best of your ability, always try to place your hooks here. This keeps all your hooks in one convenient
     * location for ease of debugging and providing a quick overview of everything your theme is doing.
     */
    protected function hooks()
    {

        // Setup general theme options
        add_action('after_setup_theme', ['\NV\Theme\Core\Setup', 'after_setup_theme']);

        // Load styles and scripts
        add_action('wp_enqueue_scripts', ['\NV\Theme\Core\Setup', 'enqueue_assets']);

        // Load styles and scripts
        add_action('admin_enqueue_scripts', ['\NV\Theme\Core\Setup', 'enqueue_admin_assets']);

        // Register sidebars
        add_action('widgets_init', ['\NV\Theme\Core\Setup', 'sidebars']);

        // Any customizations to the body_class() function
        add_filter('body_class', ['\NV\Theme\Core\Setup', 'body_class']);

        // Change WordPress' .sticky css class to .stickied to prevent conflict with Foundation
        add_filter('post_class', ['\NV\Theme\Core\Setup', 'sticky_post_class']);


        /** THEME CUSTOMIZATION *******************************************************/

        // Setup the theme \NV\Theme\Core\Customizer options
        add_action('customize_register', ['\NV\Theme\Core\Customizer', 'register']);

        // Load the customized style data on the frontend
        add_action('wp_head', ['\NV\Theme\Core\Customizer', 'header_output']);

        // Load any javascript needed for live preview updates
        add_action('customize_preview_init', ['\NV\Theme\Core\Customizer', 'live_preview']);


        /** INTEGRATE THEME WITH TINYMCE EDITOR **************************************/

        // Adds custom stylesheet to the editor window so styling preview is accurate ( can also use add_editor_style() )
        add_filter('mce_css', ['\NV\Theme\Core\Editor', 'style']);

        // Add a new "Styles" dropdown to the TinyMCE editor toolbar
        add_filter('mce_buttons_2', ['\NV\Theme\Core\Editor', 'buttons']);

        // Populate our new "Styles" dropdown with options/content
        add_filter('tiny_mce_before_init', ['\NV\Theme\Core\Editor', 'settings_advanced']);


        /** INTEGRATE THEME WITH GUTENBERG EDITOR ************************************/
        //add_action('enqueue_block_editor_assets', ['NV\Theme\Core\Gutenberg', 'enqueue_assets']);
        add_action('init', ['NV\Theme\Core\Gutenberg', 'example_block']);
    }


    /**
     * Returns the plugin's root namespace path, or prepends the plugin namespace(s) to the provided classname string.
     *
     * @param string $class The fully qualified class name
     *
     * @return string
     */
    public function get_ns($class = '')
    {
        return '\\' . __NAMESPACE__ . '\\' . $class;
    }


    /**
     * Registers a PSR-4 compliant class autoloader.
     */
    protected function autoload()
    {

        spl_autoload_register(
            function ($class) {
                // project-specific namespace prefix
                $prefix = __NAMESPACE__ . '\\';

                // base directory for the namespace prefix
                $base_dir = trailingslashit(dirname(__FILE__));

                // does the class use the namespace prefix?
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    // no, move to the next registered autoloader
                    return;
                }

                // get the relative class name
                $relative_class = substr($class, $len);

                // replace the namespace prefix with the base directory, replace namespace separators with directory
                // separators in the relative class name, append with .php
                $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

                // if the file exists, require it
                if (file_exists($file)) {
                    require $file;
                }
            }
        );

    }

    /**
     * Initialize the log property with monolog, if it's available.
     */
    protected function log_init()
    {
        // Setup the logger, if available
        if (file_exists($this->paths->vendor . 'autoload.php')) {
            require $this->paths->vendor . 'autoload.php';
            $this->log = new \Monolog\Logger('nouveau');
        }
    }


    /**
     * Initializes the class.
     *
     * This is lower in the class since it's unlikely you'll need to customize it.
     */
    protected function __construct()
    {
        $this->autoload();
        $this->paths = new Paths(__FILE__);
        $this->urls  = new Urls();
        $this->log_init();
        $this->hooks();
        Setup::content_width($this->content_width);
    }


    /**
     * Singleton method for accessing this classe's instance.
     *
     * @return Core
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

}

Core::i();
