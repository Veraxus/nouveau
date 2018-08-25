<?php

namespace NV\Theme\Utils\Generate;

/**
 * A utility class that can be used for dynamic/programmatic generation of markup.
 */
class Markup
{

    /**
     * Generates a markup tag.
     *
     * @param string $tag The element name.
     * @param string|array $content Optional. Any content (html) to used inside the element. If array, content will be sent to gen() recursively.
     * @param array $atts Optional. Associative array (recommended) or a string containing pre-processed attributes.
     * @param boolean $is_solo Optional. Whether this tag is self-contained (such as <img/> or <br/>)
     *
     * @return string Returns the assembled element html.
     */
    public static function make($tag, $content = '', $atts = [], $is_solo = false)
    {
        return self::make_array(
            [
                'tag' => $tag,
                'content' => $content,
                'atts' => $atts,
                'solo' => $is_solo,
            ]
        );
    }


    /**
     * Generates a markup tag from a complex array of arguments.
     *
     * @param array $args
     * @property string $tag The tags name
     * @property string|array $content Content to put inside the tag. If an array is provided, the array will be processed into a tag recursively.
     * @property array $atts An associative array to convert to keys and values.
     * @property bool $solo Is this a self-contained tag? Defaults to false.
     *
     * @return string Returns the assembled element html.
     */
    public static function make_array($args)
    {

        $args = self::default_atts(
            [
                'tag' => '',
                'content' => '',
                'atts' => [],
                'solo' => false,
            ],
            $args
        );

        // If content is an array, recurse
        if (is_array($args['content'])) {
            $args['content'] = self::make_array($args['content']);
        }

        // Generate the element's opening tag (sans closing bracket)
        $return = sprintf('<%s', $args['tag']);

        // Add attributes?
        if ($args['atts']) {
            $return .= (is_array($args['atts'])) ? self::atts($args['atts']) : $args['atts'];
        }

        // Determine how the element closes...
        if (!empty($args['content'])) {
            // Content with an explicit closing tag
            $return .= sprintf('>%s</%s>', $args['content'], $args['tag']);
        } else {
            if ($args['solo']) {
                // Solo tag (like br, hr, img, etc)
                $return .= ' />';
            } else {
                // Normal tag with no content
                $return .= sprintf('></%s>', $args['tag']);
            }
        }

        return $return;
    }


    /**
     * Turns an associative array into HTML-ready attribute-value pairs.
     *
     * Any array values which are also arrays are turned into space-delimited word values (in the vein of the CSS classes).
     *
     * @param array $atts An associative array of attributes and values.
     *
     * @return string Attribute-value pairs ready to be used in an HTML element.
     */
    public static function atts($atts)
    {
        $return = '';

        foreach ($atts as $att => $val) {
            if (is_array($val) || is_object($val)) {
                $return .= sprintf(' %s="%s"', sanitize_title_with_dashes($att), trim(esc_attr(implode($val, ' '))));
            } else {
                $return .= sprintf(' %s="%s"', sanitize_title_with_dashes($att), trim(esc_attr($val)));
            }
        }

        return $return;
    }

    /**
     * Used internally to merge default values with the $atts passed to an HTML shortcut method.
     *
     * @param array $defaults An associative array of default key=>value pairs
     * @param array $atts Optional. Override specified attributes.
     *
     * @return array Returns an array where the defaults are overwritten with the new values
     */
    protected static function default_atts($defaults = [], $atts = [])
    {
        return array_merge($defaults, $atts);
    }


    /**
     * Generates a randomized element id.
     *
     * @return string A 9-digit randomized attribute-safe id. e.g. "rand-1459"
     */
    public static function rand_int()
    {
        return 'rand-' . mt_rand(1000, 9999);
    }

}