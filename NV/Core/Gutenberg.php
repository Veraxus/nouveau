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
 */
class Gutenberg
{

    /**
     * Enqueues assets needed by Gutenberg and registers the block
     *
     * @hook action 'enqueue_block_editor_assets'
     */
    public static function example_block()
    {
        wp_register_script(
            'nv-gutes-block-example',
            Core::i()->urls->get_js('gutenberg.min.js'),
            ['wp-blocks', 'wp-i18n', 'wp-element']
        );

        wp_enqueue_style(
            'nv-example-gutes-css',
            Core::i()->urls->get('gutenberg.css', 'css'),
            ['wp-edit-blocks']
        );

        register_block_type(
            'nv-gutenberg/block-example',
            [
                'editor_script' => 'nv-gutes-block-example',
            ]
        );
    }

    /**
     * Enqueues assets needed by Gutenberg
     *
     * @hook action 'enqueue_block_editor_assets'
     */
    public static function enqueue_assets()
    {
        wp_enqueue_script(
            'nv-example-gutes-js',
            Core::i()->urls->get_js('gutenberg.min.js'),
            ['wp-blocks', 'wp-i18n', 'wp-element']
        );

        wp_enqueue_style(
            'nv-example-gutes-css',
            Core::i()->urls->get('gutenberg.css', 'css'),
            ['wp-edit-blocks']
        );
    }


}