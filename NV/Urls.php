<?php

namespace NV\Theme;

use DDMPlugin\Plugin;

/**
 * Generates convenient URLs for key theme locations.
 *
 * @method string|\Exception theme(string $location)
 * @method string|\Exception node(string $location)
 * @method string|\Exception assets(string $location)
 * @method string|\Exception build(string $location)
 * @method string|\Exception dist(string $location)
 * @method string|\Exception img(string $location)
 * @method string|\Exception css(string $location)
 * @method string|\Exception js(string $location)
 */
class Urls
{

    /** @var string Uri for the theme directory */
    public $theme;

    /** @var string Uri for the theme's bower_components directory */
    public $node;

    /** @var string Uri for the theme's assets directory */
    public $assets;

    /** @var string Uri for the theme's build/precompiled assets directory */
    public $build;

    /** @var string Uri for the theme's distributable/compiled assets directory */
    public $dist;

    /** @var string Uri for the theme's distributable images directory */
    public $img;

    /** @var string Uri for the theme's distributable css directory */
    public $css;

    /** @var string Uri for the theme's distributable javascript directory */
    public $js;

    /**
     * Urls constructor.
     */
    public function __construct()
    {
        $this->theme  = trailingslashit(get_template_directory_uri());
        $this->node   = $this->theme . 'node_modules/';
        $this->assets = $this->theme . 'assets/';
        $this->build  = $this->assets . 'build/';
        $this->dist   = $this->assets . 'dist/';
        $this->img    = $this->dist . 'images/';
        $this->css    = $this->dist . 'css/';
        $this->js     = $this->dist . 'js/';
    }

    /**
     * Returns a Uri for the specified file.
     *
     * @param string $filename
     * @param string $loc The name of the Urls class property path. Defaults to theme.
     *
     * @return string
     */
    public function get($filename, $loc = 'theme')
    {
        return $this->$loc . $filename;
    }

    /**
     * Returns JS enqueue uri based on WP_DEBUG setting.
     *
     * If WP_DEBUG is on, this will attempt to fetch a non-minified JS file from assets/build/js, if available. If there
     * is no corresponding .js file in assets/build, then this will simply serve the dist path instead.
     *
     * @param string $file The .min.js file that you want to load from assets/dist/js
     * @param string $loc The url path to pass to get_url(), defaults to 'js'
     *
     * @return string Uri for the javascript asset
     */
    public function get_js($file, $loc = 'js')
    {
        // Get debug version, if available.
        if (WP_DEBUG && 'js' === $loc) {
            $buildfile = str_replace('.min.js', '.js', $file);
            if (file_exists(Core::i()->paths->build('js/' . $buildfile))) {
                return $this->build . 'js/' . $buildfile;
            }
        }

        return $this->$loc . $file;
    }


    /**
     * Gets a uri if the call matches an existing property
     *
     * @param string $name The name of the property to use.
     * @param array $args The file to append to the requested uri.
     * @return string The uri for the specified file
     * @throws \Exception If the method does not match an existing property.
     */
    public function __call($name, $args)
    {
        if (isset($this->$name)) {
            return $this->$name . $args[0];
        }
        throw new \Exception('Called a magic method for a property that doesn\'t exist: Urls->' . $name);
    }

}