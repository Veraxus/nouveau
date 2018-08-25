<?php

namespace NV\Theme;

/**
 * Generates convenient URLs for key theme locations.
 */
class Urls
{

    /** @var string Uri for the theme directory */
    public $theme;

    /** @var string Uri for the theme's bower_components directory */
    public $node;

    /** @var string Uri for the theme's distributable assets directory */
    public $assets;

    /** @var string Uri for the theme's build/precompiled assets directory */
    public $build;

    /** @var string Uri for the theme's images directory */
    public $img;

    /** @var string Uri for the theme's css directory */
    public $css;

    /** @var string Uri for the theme's javascript directory */
    public $js;

    /**
     * Urls constructor.
     */
    public function __construct()
    {
        $this->theme  = trailingslashit(get_template_directory_uri());
        $this->node   = $this->theme . 'node_modules/';
        $this->build  = $this->theme . 'assets/build/';
        $this->assets = $this->theme . 'assets/dist/';
        $this->img    = $this->assets . 'images/';
        $this->css    = $this->assets . 'css/';
        $this->js     = $this->assets . 'js/';
    }

    /**
     * Returns a Uri for the specified file.
     *
     * @param string $filename
     * @param string $path The name of the Urls class property path. Defaults to theme.
     *
     * @return string
     */
    public function get( $filename, $path = 'theme' )
    {
        return $this->$path . $filename;
    }

    /**
     * Returns JS enqueue path based on WP_DEBUG setting. If WP_DEBUG is true, the src version will be used, otherwise
     * the minified version will be used. Assumes src files are in /assets/js/src/ and min files are in /assets/js/
     *
     * @param string $filename The minified filename to process
     * @param string $path The url path to pass to get_url(), defaults to 'js'
     *
     * @return string Uri for the javascript asset
     */
    public function get_js($filename, $path = 'js')
    {

        // Use theme's src js if debug is true
        if (WP_DEBUG && 'js' === $path) {
            // Strip the .min
            $filename = str_replace('.min.js', '.js', $filename);
            return $this->build . 'js/' . $filename;
        }

        return $this->$path . $filename;
    }

}