<?php

namespace NV\Theme;

/**
 * Registers theme uris with the Core class.
 */
class CoreUrls
{

    /** @var string Uri for the theme directory */
    public $theme;

    /** @var string Uri for the theme's bower_components directory */
    public $node;

    /** @var string Uri for the theme's assets directory */
    public $assets;

    /** @var string Uri for the theme's images directory */
    public $img;

    /** @var string Uri for the theme's css directory */
    public $css;

    /** @var string Uri for the theme's javascript directory */
    public $js;

    function __construct()
    {
        $this->theme  = trailingslashit(get_template_directory_uri());
        $this->node   = $this->theme . 'node_modules/';
        $this->assets = $this->theme . 'assets/dist/';
        $this->img    = $this->assets . 'images/';
        $this->css    = $this->assets . 'css/';
        $this->js     = $this->assets . 'js/';
    }

}