<?php

namespace NV\Theme\Core;

use NV\Theme\Core;
use NV\Theme\Utils\WordPress;

/**
 * Adds Foundation components to WordPress's modular Gutenberg editor
 *
 * There's not much to see here because Gutenberg is 99.9% Javascript. To get up to speed on how to create Gutenberg
 * blocks, read: https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/
 *
 * There are just 5 steps to creating a Gutenberg block in PHP. The rest of the work happens in Javascript.
 *
 * STEP 1
 * Decide on a unique slug to identify your block.
 *
 * STEP 2
 * Register (but don't enqueue) your javascript
 *
 * STEP 3
 * Register (but don't enqueue) your styles
 *
 * STEP 4
 * Register your content block with WordPress
 *
 * STEP 5
 * Pass translations to JS. Note that the "before" position is required.
 *
 * NOTE: We don't use get_js() in here because React syntax is not natively browser friendly. The JS MUST be compiled.
 */
class Gutenberg
{

    /** @var string A theme-wide namespace to prefix your Gutenberg blocks */
    const NAMESPACE = 'nouveau-theme';

    /**
     * Registers all our custom blocks
     */
    public static function register_blocks()
    {
        // Abort if Gutenberg isn't active
        if (!self::is_active()) {
            return;
        }

        self::block_hello();
        self::block_editable();
    }

    /**
     * Manipulates the list of block categories that group together block types.
     *
     * By default, creates a new category named "NOUVEAU"
     *
     * @hook filter 'block_categories'
     *
     * @param array $categories The existing categories array
     * @param \WP_Post $post The current post object
     * @return array The filtered categories array
     */
    public static function categories($categories, \WP_Post $post)
    {
        return array_merge(
            $categories,
            [
                [
                    'slug'  => self::NAMESPACE,
                    'title' => __('NOUVEAU', 'nv_lang_scope'),
                ],
            ]
        );
    }

    /**
     * Enqueues assets needed by Gutenberg and registers the block.
     *
     * @hook action 'init'
     */
    public static function block_hello()
    {
        $block_slug = 'example-hello';

        wp_register_script(
            $block_slug,
            Core::i()->urls->js('gutenberg/block.hello.min.js'),
            ['wp-blocks', 'wp-i18n', 'wp-element']
        );

        register_block_type(
            Gutenberg::NAMESPACE . '/' . $block_slug,
            [
                'editor_script' => $block_slug,
            ]
        );

        wp_add_inline_script(
            $block_slug,
            sprintf(
                'var %s = { localeData: %s };',
                WordPress::to_camelCase($block_slug),
                json_encode(gutenberg_get_jed_locale_data('nv_lang_scope'))
            ),
            'before'
        );
    }

    /**
     * Enqueues assets needed by Gutenberg and registers the block.
     *
     * @hook action 'init'
     */
    public static function block_editable()
    {
        $block_slug = 'example-editable';

        wp_register_script(
            $block_slug,
            Core::i()->urls->js('gutenberg/block.editable.min.js'),
            ['wp-blocks', 'wp-i18n', 'wp-element']
        );

        register_block_type(
            Gutenberg::NAMESPACE . '/' . $block_slug,
            [
                'editor_script' => $block_slug,
            ]
        );

        wp_add_inline_script(
            $block_slug,
            sprintf(
                'var %s = { localeData: %s };',
                WordPress::to_camelCase($block_slug),
                json_encode(gutenberg_get_jed_locale_data('nv_lang_scope'))
            ),
            'before'
        );
    }

    /**
     * Is Gutenberg active?
     *
     * @return bool
     */
    public static function is_active()
    {
        return function_exists('register_block_type');
    }

    /**
     * Registers Gutenberg stylesheet so we don't need to apply isolated styles to every block
     *
     * @hook action 'enqueue_block_editor_assets'
     */
    public static function styles()
    {
        wp_enqueue_style(
            self::NAMESPACE,
            Core::i()->urls->css('gutenberg.css'),
            ['wp-edit-blocks'],
            filemtime(Core::i()->paths->dist('css/gutenberg.css'))
        );
    }


}