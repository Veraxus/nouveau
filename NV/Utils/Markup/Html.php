<?php

namespace NV\Theme\Utils\Markup;

/**
 * Shortcuts to speed up the easy generation of dynamic HTML, extending the MarkupGenerator utility class.
 */
class Html extends Generator
{

    /**
     * Generates an <a> element
     *
     * @param string $href The link
     * @param array $atts An associative array of attributes (such as href)
     * @param string $content Content to put between the opening and closing tags
     * @param bool $echo
     *
     * @return string
     */
    public static function a($href = '#', $atts = [], $content = '', $echo = false)
    {
        $atts = parent::default_atts(
            [
                'href' => $href,
            ],
            $atts
        );

        $return = parent::make('a', $atts, $content);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates a <div> element
     *
     * @param array $atts
     * @param string $content
     * @param bool $echo
     *
     * @return string
     */
    public static function div($atts = [], $content = '', $echo = false)
    {
        $return = parent::make('div', $atts, $content);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates a <ul> element
     *
     * @param string $content
     * @param array $atts
     * @param bool|false $echo
     *
     * @return string
     */
    public static function ul($content = '', $atts = [], $echo = false)
    {
        $return = parent::make('ul', $atts, $content);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates an <li> element
     *
     * @param string $content
     * @param array $atts
     * @param bool|false $echo
     *
     * @return string
     */
    public static function li($content = '', $atts = [], $echo = false)
    {
        $return = parent::make('li', $atts, $content);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates an <img> element
     *
     * @param string $src
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function img($src = '', $atts = [], $echo = false)
    {
        $atts = parent::default_atts(
            [
                'src' => (!empty($src)) ? $src : '',
                'alt' => '',
            ],
            $atts
        );

        $return = parent::make('img', $atts, '', true);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates an <input> element
     *
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function input($name = '', $atts = [], $echo = false)
    {
        $atts = parent::default_atts(
            [
                'id' => (!empty($name)) ? $name : parent::rand_int(),
                'name' => (!empty($name)) ? $name : parent::rand_int(),
                'type' => 'text',
            ],
            $atts
        );

        $return = parent::make('input', $atts);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates an <input> element of type "text"
     *
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function input_text($name = '', $atts = [], $echo = false)
    {
        return self::input($name, $atts, $echo);
    }

    /**
     * Generates an <input> element of type "checkbox"
     *
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function input_checkbox($name = '', $atts = [], $echo = false)
    {
        $atts = parent::default_atts(
            [
                'id' => (!empty($name)) ? $name : parent::rand_int(),
                'name' => (!empty($name)) ? $name : parent::rand_int(),
                'type' => 'checkbox',
            ],
            $atts
        );

        $return = parent::make('input', $atts);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates an <input> element of type "radio"
     *
     * @param string $name
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function input_radio($name = '', $atts = [], $echo = false)
    {
        $atts = parent::default_atts(
            [
                'id' => (!empty($name)) ? $name : parent::rand_int(),
                'name' => (!empty($name)) ? $name : parent::rand_int(),
                'type' => 'radio',
            ],
            $atts
        );

        $return = parent::make('input', $atts);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

    /**
     * Generates a <label> element
     *
     * @param string $for
     * @param array $atts
     * @param bool $echo
     *
     * @return string
     */
    public static function label($for = '', $atts = [], $echo = false)
    {
        $atts = parent::default_atts(
            [
                'for' => (!empty($for)) ? $for : '',
            ],
            $atts
        );

        $return = parent::make('label', $atts);
        if ($echo) {
            echo $return;
        }

        return $return;
    }

}