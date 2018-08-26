<?php

namespace NV\Theme\Core;

use NV\Theme\Core;

/**
 * Adds Foundation components to WordPress's modular Gutenberg editor
 *
 * There's not much to see here because Gutenberg is 99.9% Javascript. To get up to speed on how to create Gutenberg
 * blocks, read: https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/
 *
 * You can find gutenberg.js and gutenberg.scss in assets/build/js/ and assets/build/sass/, respectively.
 *
 * @const string NS The namespace slug to use for new Gutenberg block types
 */
class Gutenberg
{

    const NAMESPACE = 'nv-gutenberg';

    /**
     * Enqueues assets needed by Gutenberg and registers the block
     *
     * @hook action 'init'
     */
    public static function block_example()
    {
        /*
         * STEP 1
         * Decide on a unique slug to
         */
        $block_slug = 'block-example';

        // Abort if Gutenberg isn't active
        if (!self::is_active()) {
            return;
        }

        // Register the javascript
        wp_register_script(
            $block_slug,
            Core::i()->urls->get_js('gutenberg.min.js'),
            ['wp-blocks', 'wp-i18n', 'wp-element']
        );

        // Register the block type with WordPress
        register_block_type(
            Gutenberg::NAMESPACE . '/' . $block_slug,
            [
                'editor_script' => $block_slug,
            ]
        );

        /*
         * Pass already loaded translations to our JavaScript.
         *
         * This happens _before_ our JavaScript runs, afterwards it's too late.
         */
        wp_add_inline_script(
            'gutenberg-examples-01-esnext',
            sprintf(
                'var gutenberg_examples_01_esnext = { localeData: %s };',
                json_encode(gutenberg_get_jed_locale_data('gutenberg-examples'))
            ),
            'before'
        );
    }

    /**
     * Is Gutenberg active?
     * @return bool
     */
    public static function is_active()
    {
        return function_exists('register_block_type');
    }

    /**
     * Enqueues assets needed by Gutenberg
     *
     * @hook action 'enqueue_block_editor_assets'
     */
    public static function enqueue_assets()
    {
//        wp_enqueue_script(
//            'nv-example-gutes-js',
//            Core::i()->urls->get_js('gutenberg.min.js'),
//            ['wp-blocks', 'wp-i18n', 'wp-element']
//        );
//
//        wp_enqueue_style(
//            'nv-example-gutes-css',
//            Core::i()->urls->get('gutenberg.css', 'css'),
//            ['wp-edit-blocks']
//        );
    }


}