<?php

namespace NV\Theme\Core;

/**
 * Defines key locations of theme assets for easy retrieval.
 *
 * @used-by \NV\Theme\Core
 *
 * @method string|\Exception theme(string $location)
 * @method string|\Exception node(string $location)
 * @method string|\Exception nv(string $location)
 * @method string|\Exception vendor(string $location)
 * @method string|\Exception parts(string $location)
 * @method string|\Exception assets(string $location)
 * @method string|\Exception build(string $location)
 * @method string|\Exception dist(string $location)
 * @method string|\Exception css(string $location)
 * @method string|\Exception img(string $location)
 * @method string|\Exception js(string $location)
 * @method string|\Exception langs(string $location)
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

    /** @var string Full location of the theme's assets directory */
    public $assets;

    /** @var string Full location of the theme's assets/build directory */
    public $build;

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

        $this->node   = $this->theme . 'node_modules/';
        $this->vendor = $this->theme . 'vendor/';
        $this->parts  = $this->theme . 'parts/';

        $this->assets = $this->theme . 'assets/';
        $this->dist   = $this->assets . 'dist/';
        $this->build  = $this->assets . 'build/';
        $this->css    = $this->dist . 'css/';
        $this->img    = $this->dist . 'img/';
        $this->js     = $this->dist . 'js/';
        $this->langs  = $this->assets . 'languages/';
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
        if (isset($this->$name)) {
            return $this->$name . $args[0];
        }

        throw new \Exception('Called a magic method for a property that doesn\'t exist: ' . __CLASS__ . '->' . $name ?: 'NULL');
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
     * @return string Uri for the javascript asset
     *
     * @throws \Exception *No it won't. Don't believe IntelliJ. It lies.
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
            $buildpath = $paths->build($loc . '/' . $buildfile);

            // Confirm the file exists before trying to serve it
            if (file_exists($buildpath)) {
                return $this->build($loc . '/' . $buildfile);
            }
        }

        return $this->$loc . $file;
    }
}