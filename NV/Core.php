<?php

namespace NV\Theme;

/**
 * The heart and soul of your theme. Can be accessed via a convenient singleton: Core::i()
 */
class Core
{

    /** @var self Stores the singleton instance */
    private static $instance;

    /** @var Core\Locations An object containing important theme directory paths */
    public $paths;

    /** @var Core\Locations An object containing important theme urls */
    public $urls;

    /** @var \Monolog\Logger A log object */
    public $log;

    /** @var int The max width of content to register with WordPress */
    const CONTENT_WIDTH = 1200;


    /**
     * Initializes all the theme's hooks
     *
     * To the best of your ability, always try to place your hooks here. This keeps all your hooks in one convenient
     * location for ease of debugging and providing a quick overview of everything your theme is doing.
     */
    protected function hooks()
    {

        /** PRIMARY THEME FUNCTIONALITY ************************************************/

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

        // Setup the theme \NV\Theme\Admin\Customizer
        add_action('customize_register', ['\NV\Theme\Admin\Customizer', 'register']);

        // Load the customized style data on the frontend
        add_action('wp_head', ['\NV\Theme\Admin\Customizer', 'header_output']);

        // Load any javascript needed for live preview updates
        add_action('customize_preview_init', ['\NV\Theme\Admin\Customizer', 'live_preview']);


        /** INTEGRATE THEME WITH TINYMCE EDITOR **************************************/

        // Adds custom stylesheet to the editor window so styling preview is accurate ( can also use add_editor_style() )
        add_filter('mce_css', ['\NV\Theme\Admin\Editor', 'style']);

        // Add a new "Styles" dropdown to the TinyMCE editor toolbar
        add_filter('mce_buttons_2', ['\NV\Theme\Admin\Editor', 'buttons']);

        // Populate our new "Styles" dropdown with options/content
        add_filter('tiny_mce_before_init', ['\NV\Theme\Admin\Editor', 'settings_advanced']);


        /** CUSTOM GUTENBERG CATEGORIES & BLOCKS ************************************/

        add_action('enqueue_block_editor_assets', ['\NV\Theme\Admin\Gutenberg', 'styles']);
        add_filter('block_categories', ['\NV\Theme\Admin\Gutenberg', 'categories'], 10, 2);
        add_action('init', ['\NV\Theme\Admin\Gutenberg', 'register_blocks']);

    }

    /**
     * Returns the plugin's root namespace path, or prepends the plugin namespace(s) to the provided classname string.
     *
     * @param string $class The fully qualified class name
     *
     * @return string
     */
    public function namespace($class = '')
    {
        return '\\' . __NAMESPACE__ . '\\' . $class;
    }

    /**
     * Tells WordPress to look for core template types in the templates directory.
     *
     * This helps keep the theme's primary directory a lot less messy without dramatically changing the way WordPress
     * templating system works. Note that there is no single hook that can do this because the {}_template_hierarchy
     * hook is dynamic. This means we need to keep an array of all the core template types and loop over them,
     * registering the hook for each type/group.
     */
    public function set_template_dir()
    {
        // Every template type checked in get_query_template()
        $core_templates = [ 'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date',
            'embed', 'home', 'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment' ];

        foreach ($core_templates as $templates) {
            // Add a filter for each of the template groups/types
            add_filter($templates . '_template_hierarchy', function ($templates) {

                // Make a copy of the array with NOUVEAU's template dir prepended
                $nv_templates = array_map(function ($val) {
                    return 'templates/' . $val;
                }, $templates);

                // Merge our array with the original
                $templates = array_merge($nv_templates, $templates);

                // Return it so WordPress can find our templates
                return $templates;
            });
        }
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
     * Initialize the Composer autoloader
     */
    protected function vendors_init()
    {
        $vendor_path = $this->paths->vendor('autoload.php');

        // If the vendor path doesn't exist, stop
        if (!file_exists($vendor_path)) {
            return;
        }

        // Load the Composer autoloader
        require $vendor_path;

        // Initalizde the logger
        $this->log = new \Monolog\Logger('nouveau');
    }


    /**
     * Initializes the class.
     *
     * This is lower in the class since it's unlikely you'll need to customize it.
     */
    protected function __construct()
    {
        $this->autoload();
        $this->paths = new Core\Locations('paths');
        $this->urls  = new Core\Locations('urls');
        $this->vendors_init();
        $this->set_template_dir();
        $this->hooks();
        Core\Setup::content_width();
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
