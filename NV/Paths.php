<?php

namespace NV\Theme;

/**
 * Registers absolute system paths with the Core class.
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

    function __construct($file)
    {
        $this->theme  = trailingslashit(get_template_directory());
        $this->nv     = trailingslashit(dirname($file));
        $this->node   = $this->theme . 'node_modules/';
        $this->vendor = $this->theme . 'vendor/';
        $this->parts  = $this->theme . 'parts/';
        $this->assets = $this->theme . 'assets/dist/';
        $this->img    = $this->assets . 'img/';
        $this->langs  = $this->assets . 'languages/';
    }

}