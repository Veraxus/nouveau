<?php

namespace NV\Theme;

/**
 * Generates convenient absolute system paths for key theme locations.
 */
class Paths
{

    /** @var string Absolute path to the theme directory */
    public $theme;

    /** @var string Absolute path to the theme's NV directory */
    public $nv;

    /** @var string Absolute path to the theme's bower_components directory */
    public $node;

    /** @var string Absolute path to the theme's parts directory */
    public $parts;

    /** @var string Absolute path to the theme's assets directory */
    public $assets;

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
        $this->assets = $this->theme . 'assets/dist/';
        $this->build  = $this->theme . 'assets/build/';
        $this->img    = $this->assets . 'img/';
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
        return $this->$$path . $file;
    }

}