<?php

namespace NV\Theme;

use DDMPlugin\Plugin;

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

    /** @var string Uri for the theme's distributable javascript directory */
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
     * @param string $loc The name of the Urls class property path. Defaults to theme.
     *
     * @return string
     */
    public function get( $filename, $loc = 'theme' )
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
            $srcpath = Core::i()->paths->get( $buildfile, 'build' );
            if ( file_exists( $srcpath ) ) {
                return $this->build . 'js/' . $buildfile;
            }
        }

        return $this->$loc . $file;
    }

}