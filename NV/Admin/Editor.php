<?php

namespace NV\Theme\Admin;

use NV\Theme\Core;

/**
 * This allows customization of the WordPress "Classic" TinyMCE editor. This will add custom styles to the editor
 * allowing non-technical admins to more easily add advanced styling to pages/posts.
 *
 * In addition to the following class methods, you should also ensure that complementary classes are enqueued on the
 * front end as well.
 */
class Editor
{

    /**
     * Add stylesheet to the editor window so that previews are accurate.
     *
     * @hook action 'mce_css'
     *
     * @param $url
     *
     * @return string
     */
    public static function style($url)
    {
        //If there's already a URL, add a comma to delimit new style
        if (!empty($url)) {
            $url .= ',';
        }

        //Add our new style
        $url .= Core::i()->urls->css('editor.css');

        return $url;
    }

    /**
     * Add the "Styles" dropdown to the editor toolbar. By default, it's not included in the WordPress version of
     * TinyMCE - so we simply need to add it back to the button array. In this case, we're adding it to the
     * mce_buttons_2 bar.
     *
     * @hook action 'mce_buttons_2'
     *
     * @param $buttons
     *
     * @return mixed
     */
    public static function buttons($buttons)
    {
        array_unshift($buttons, 'removeformat');
        array_unshift($buttons, 'styleselect');

        return $buttons;
    }

    /**
     * Populate the new "Styles" dropdown with options.
     *
     * This is the simple implementation and will only allow users to create new <span> elements when they use styles
     * defined this way. For more control, or to allow manipulation of existing elements, see the settings_advanced()
     * method instead.
     *
     * @hook action 'tiny_mce_before_init'
     *
     * @param array $settings The TinyMCE settings array.
     *
     * @return array
     */
    public static function settings_simple($settings)
    {
        //First, we define the styles we want to add in format 'Style Name' => 'css classes'
        $classes = [
            __('Test', 'nv_lang_scope') => 'warnme',
        ];

        //Delimit styles by semicolon in format 'Title=classes;' so TinyMCE can use it
        if (!empty($settings['theme_advanced_styles'])) {
            $settings['theme_advanced_styles'] .= ';';
        } else {
            //If there's nothing defined yet, define it
            $settings['theme_advanced_styles'] = '';
        }

        //Loop through our classes and add them to TinyMCE
        $class_settings = '';
        foreach ($classes as $name => $value) {
            $class_settings .= "{$name}={$value};";
        }

        //Add our new class settings to the TinyMCE $settings array
        $settings['theme_advanced_styles'] .= trim($class_settings, '; ');

        return $settings;
    }

    /**
     * Populate the new "Styles" dropdown with options. This uses more of the TinyMCE API to allow for more fine-tuned
     * control over what types of elements can be interacted with or created by using the Styles dropdown.
     *
     * Unlike the previous example, this one uses a multidimensional array to build a TinyMCE-compatible JSON object
     * with advanced styling rules.
     *
     * @hook action 'tiny_mce_before_init'
     *
     * @param array $settings The TinyMCE settings array.
     *
     * @return array
     */
    public static function settings_advanced($settings)
    {
        /*
         * We use a simple multidimensional array to define our advanced style rules. This will then be converted
         * into JSON for use with TinyMCE. For full details, see the provided @link.
         *
         * Each array within $styles represents a new style rule. It should contain a title (which will appear in the
         * Styles drop-down list) and one or more format definitions (usually at least two). Formats include:
         *
         * 'inline'     : string. Specify an inline element to create/modify. e.g. 'span'
         * 'block'      : string. Specify a block element to create/modify. e.g. 'h1' or 'div'
         * 'selector'   : string. A CSS3 selector. When provided, changes will only be applied when element matches this selector.
         * 'classes'    : string. A space-separated list of classes to add.
         * 'styles'     : array. Associative array of CSS styles => properties to add.
         * 'attributes' : array. Associative array of HTML attributes => values to add.
         * 'exact'      : bool. Set to true to force creation of new elements (true disables the 'merge similar styles' feature).
         * 'wrapper'    : bool. Set to true to treat new element as a container for other block-level elements
         *
         * NOTICE: TinyMCE will not create blocks out of non-blocks. If a 'block' format is used, it will only be
         * applied when a block/chunk/paragraph is selected.
         *
         * ========================
         *
         * FOUNDATION NOTES ON TINYMCE QUIRKS
         *
         * Some common default styles for Foundation are included. This is NOT exhaustive as it would make the Formats drop-down
         * very long. Feel free to customize this to your needs. When creating columns, you should select a "Small Column" option
         * FIRST, then you can apply a "Medium Column" to that afterward. This keeps things flexible, but you may need to train
         * your users on this as it's non-obvious.
         *
         * Note that TinyMCE is not smart enough to remove/replace old classes… so if you need to change from one column format to
         * another (say, "Medium 4" to "Medium 6" columns), you must unselect the old format from the TinyMCE Formats dropdown first
         * to get rid of the old class. If you don't, both classes will be applied (ick).
         *
         * Author note: I may include some custom Javascript to make Foundation more tightly and naturally integrated with TinyMCE,
         * but no promises.
         *
         * ========================
         *
         * @link http://www.tinymce.com/wiki.php/Configuration:formats
         * @var array
         */
        $styles = [

            /*
            //Example: An inline style format
            array(
                'title'     => __('Text: Cross out','nv_lang_scope'),
                'inline'    => 'span',
                'classes'   => 'strike-through',
            ),
            */

            /*
            //Example: An element-smart selector (target only images)
            array(
                'title'     => __('Image: 50% Width','nv_lang_scope'),
                'selector'  => 'img',
                'classes'   => 'half-width',
            ),
            */

            /*
            //Example: A div that wraps around any current selection
            array(
                'title'     => __('Warning Box','nv_lang_scope'),
                'block'     => 'div',
                'classes'   => 'warning box',
                'exact'     => true,
                'wrapper'   => true,
            ),
            */

            /*
            //Example: A span with inline styles
            array(
                'title'     => __('Red Uppercase Text','nv_lang_scope'),
                'inline'    => 'span',
                'styles'    => array(
                    'color'         => '#ff0000',
                    'fontWeight'    => 'bold',
                    'textTransform' => 'uppercase',
                ),
            ),
            */

            [
                'title'   => __('Section', 'nv_lang_scope'),
                'block'   => 'section',
                'wrapper' => true,
                'exact'   => true,
            ],
            [
                'title'   => __('Foundation Container', 'nv_lang_scope'),
                'block'   => 'div',
                'classes' => 'grid-container',
                'wrapper' => true,
                'exact'   => true,
            ],
            [
                'title'   => __('Foundation Row', 'nv_lang_scope'),
                'block'   => 'div',
                'classes' => 'grid-x grid-padding-x',
                'wrapper' => true,
                'exact'   => true,
            ],
            [
                'title'   => __('Column (Small 12)', 'nv_lang_scope'),
                'block'   => 'div',
                'classes' => 'small-12 cell',
                'wrapper' => true,
                'exact'   => true,
            ],
            [
                'title'   => __('Column (Small 6)', 'nv_lang_scope'),
                'block'   => 'div',
                'classes' => 'small-6 cell',
                'wrapper' => true,
                'exact'   => true,
            ],
            [
                'title'    => __('Medium 2 (Edit Column)', 'nv_lang_scope'),
                'selector' => '.cell',
                'classes'  => 'medium-2',
            ],
            [
                'title'    => __('Medium 4 (Edit Column)', 'nv_lang_scope'),
                'selector' => '.cell',
                'classes'  => 'medium-4',
            ],
            [
                'title'    => __('Medium 6 (Edit Column)', 'nv_lang_scope'),
                'selector' => '.cell',
                'classes'  => 'medium-6',
            ],

        ];

        //Encode our array as JSON, which automagically makes it TinyMCE compatible
        $settings['style_formats'] = json_encode($styles);

        return $settings;
    }


}