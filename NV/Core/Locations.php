<?php

namespace NV\Theme\Core;

/**
 * Defines key locations of theme assets for easy retrieval.
 *
 * @used-by \NV\Theme\Core
 *
 * @method string|\Exception theme(string $location, bool $relative = false)
 * @method string|\Exception node(string $location, bool $relative = false)
 * @method string|\Exception nv(string $location, bool $relative = false)
 * @method string|\Exception vendor(string $location, bool $relative = false)
 * @method string|\Exception templates(string $location, bool $relative = false)
 * @method string|\Exception parts(string $location, bool $relative = false)
 * @method string|\Exception assets(string $location, bool $relative = false)
 * @method string|\Exception build(string $location, bool $relative = false)
 * @method string|\Exception dist(string $location, bool $relative = false)
 * @method string|\Exception css(string $location, bool $relative = false)
 * @method string|\Exception img(string $location, bool $relative = false)
 * @method string|\Exception js(string $location, bool $relative = false)
 * @method string|\Exception langs(string $location, bool $relative = false)
 */
class Locations
{
    /** @var string What type of location is class serving: 'paths' or 'urls' */
    public $which;

    /** @var string Full location of the theme directory */
    public $theme;

    /** @var string Full location of the theme's NV directory */
    public $nv;

    /** @var string Full location of the theme's bower_components directory */
    public $node;

    /** @var string Full location of the theme's vendor directory */
    public $vendor;

    /** @var string Full location of the theme's parts directory */
    public $parts;

    /** @var string Full location of the theme's templates directory */
    public $templates;

    /** @var string Full location of the theme's assets directory */
    public $assets;

    /** @var string Full location of the theme's assets/build directory */
    public $src;

    /** @var string Full location of the theme's assets/dist directory */
    public $dist;

    /** @var string Full location of assets/dist/css */
    public $css;

    /** @var string Full location of assets/dist/css */
    public $js;

    /** @var string Full location of the theme's image directory */
    public $img;

    /** @var string Full location of the theme's languages directory */
    public $langs;

    /**
     * Locations constructor.
     *
     * @param string $which Should be 'paths' to initial system paths or 'urls' to initialize urls
     *
     * @throws \Exception If $which is not a valid initializer argument.
     */
    public function __construct($which)
    {
        if (!in_array($which, ['urls', 'paths'])) {
            throw new \Exception("Constructor argument must equal either 'paths' or 'urls'. Argument provided: '{$which}'");
        }
        $this->which = $which;
        $this->{'base_' . $which}();
        $this->setup();
    }

    /**
     * Initializes class with system paths
     */
    public function base_paths()
    {
        $this->theme = trailingslashit(get_template_directory());
    }

    /**
     * Initializes class with urls
     */
    public function base_urls()
    {
        $this->theme = trailingslashit(get_template_directory_uri());
    }

    /**
     * Sets up all the various theme paths
     * @throws \Exception
     */
    public function setup()
    {
        if (!$this->theme) {
            throw new \Exception('Base locations are not yet initialized.');
        }

        $this->nv = $this->theme . 'NV/';

        $this->langs     = $this->theme . 'languages/';
        $this->node      = $this->theme . 'node_modules/';
        $this->vendor    = $this->theme . 'vendor/';
        $this->templates = $this->theme . 'templates/';
        $this->parts     = $this->templates . 'parts/';
        $this->assets    = $this->theme . 'assets/';
        $this->dist      = $this->assets . 'dist/';
        $this->src     = $this->assets . 'build/';
        $this->css       = $this->dist . 'css/';
        $this->img       = $this->dist . 'img/';
        $this->js        = $this->dist . 'js/';
    }

    /**
     * Gets a path if the call matches an existing property
     *
     * @param string $name The name of the property to use.
     * @param array $args The file to append to the requested location.
     * @return string The file path
     * @throws \Exception If the method does not match an existing property.
     */
    public function __call($name, $args)
    {
        // If the property exists, return the location
        if (!isset($this->$name)) {
            throw new \Exception('Called a magic method for a property that doesn\'t exist: ' . __CLASS__ . '->' . $name ?: 'NULL');
        }

        // Put together the path
        $location = $this->$name . $args[0];

        // Requesting a theme-relative location? Strip out theme location.
        if (isset($args[1]) && $args[1]) {
            $location = str_replace($this->theme, '', $location);
        }

        return $location;
    }

    /**
     * Returns either the dist or build version of an asset file, based on WP_DEBUG. Mostly useful for JS.
     *
     * If WP_DEBUG is on, this will attempt to fetch a file from assets/build/$loc, if available. If there
     * is no corresponding file in assets/build, then this will simply serve the dist location instead.
     *
     * This will automatically update JS extensions if a JS path is provided.
     *
     * @param string $file The file that you want to load from assets/dist/js
     * @param string $loc The url path to pass to get_url(), defaults to 'js'
     *
     * @throws \Exception If the specified location is not a valid property
     *
     * @return string Uri for the javascript asset
     */
    public function debug_asset($file, $loc = 'js')
    {
        // Only redirect if WP_DEBUG is on
        if (WP_DEBUG) {
            // If a JS file, change .min.js to .js
            if ('js' === $loc) {
                $buildfile = str_replace('.min.js', '.js', $file);
            }

            // Find the system path for this file
            $paths     = new self('paths');
            $buildpath = $paths->src($loc . '/' . $buildfile);

            // Confirm the file exists before trying to serve it
            if (file_exists($buildpath)) {
                return $this->src($loc . '/' . $buildfile);
            }
        }

        return $this->$loc . $file;
    }
}