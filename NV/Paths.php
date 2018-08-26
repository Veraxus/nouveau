<?php

namespace NV\Theme;

use phpDocumentor\Plugin\Scrybe\Converter\RestructuredText\Visitors\DiscoverTest;

/**
 * Generates convenient absolute system paths for key theme locations.
 *
 * @method string|\Exception theme(string $location)
 * @method string|\Exception nv(string $location)
 * @method string|\Exception node(string $location)
 * @method string|\Exception vendor(string $location)
 * @method string|\Exception parts(string $location)
 * @method string|\Exception assets(string $location)
 * @method string|\Exception build(string $location)
 * @method string|\Exception dist(string $location)
 * @method string|\Exception css(string $location)
 * @method string|\Exception img(string $location)
 * @method string|\Exception langs(string $location)
 */
class Paths
{

    /** @var string Absolute path to the theme directory */
    public $theme;

    /** @var string Absolute path to the theme's NV directory */
    public $nv;

    /** @var string Absolute path to the theme's bower_components directory */
    public $node;

    /** @var string Absolute path to the theme's vendor directory */
    public $vendor;

    /** @var string Absolute path to the theme's parts directory */
    public $parts;

    /** @var string Absolute path to the theme's assets directory */
    public $assets;

    /** @var string Absolute path to the theme's assets/build directory */
    public $build;

    /** @var string Absolute path to the theme's assets/dist directory */
    public $dist;

    /** @var string Absolute path to assets/dist/css */
    public $css;

    /** @var string Absolute path to the theme's image directory */
    public $img;

    /** @var string Absolute path to the theme's languages directory */
    public $langs;

    /**
     * Paths constructor.
     *
     * @param string $file The output of __FILE__
     */
    public function __construct($file)
    {
        $this->theme  = trailingslashit(get_template_directory());
        $this->nv     = trailingslashit(dirname($file));
        $this->node   = $this->theme . 'node_modules/';
        $this->vendor = $this->theme . 'vendor/';
        $this->parts  = $this->theme . 'parts/';
        $this->assets = $this->theme . 'assets/';
        $this->dist   = $this->assets . 'dist/';
        $this->build  = $this->assets . 'build/';
        $this->css    = $this->dist . 'css/';
        $this->img    = $this->dist . 'img/';
        $this->langs  = $this->assets . 'languages/';
    }

    /**
     * Gets an absolute system path to the specified file, relative to the theme
     *
     * @param string $file The name/path of the file you want to get
     * @param string $path The property you want to use as the base path to the file
     * @return string
     */
    public function get($file, $path = 'theme')
    {
        return $this->$path . $file;
    }

    /**
     * Gets a path if the call matches an existing property
     *
     * @param string $name The name of the property to use.
     * @param array $args The file to append to the requested path.
     * @return string The file path
     * @throws \Exception If the method does not match an existing property.
     */
    public function __call($name, $args)
    {
        if (isset($this->$name)) {
            return $this->$name . $args[0];
        }
        throw new \Exception('Called a magic method for a property that doesn\'t exist: Paths->' . $name);
    }

}