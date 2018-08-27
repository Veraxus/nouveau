<?php
/**
 * The Gutenberg class
 */

namespace NV\Theme\Admin;

use NV\Theme\Core;
use NV\Theme\Utils\WordPress;

/**
 * Adds Foundation components to WordPress's modular Gutenberg editor
 *
 * There's not much to see here because Gutenberg is 99.9% Javascript. To get up to speed on how to create Gutenberg
 * blocks, read: https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/
 *
 *
 * NOTE: We don't use debug_asset() in here because React syntax is not natively browser friendly. The js MUST for
 * Gutenberg blocks is ES2016+ and MUST be compiled.
 */
class Gutenberg
{

    /** @var string A theme-wide namespace to prefix your Gutenberg blocks */
    const NAMESPACE = 'nouveau-theme';

    /**
     * Registers all our custom blocks
     *
     * @hook action 'init'
     */
    public static function register_blocks()
    {
        // Abort if Gutenberg isn't active
        if (!self::is_active()) {
            return;
        }

        // Register each of our sample blocks
        self::add_block('example-hello', 'block.hello.min.js');
        self::add_block('example-editable', 'block.editable.min.js');
    }

    /**
     * Manipulates the list of block categories that group together block types.
     *
     * By default, creates a new category named "NOUVEAU"
     *
     * @hook filter 'block_categories'
     *
     * @param array $categories The existing categories array
     * @param \WP_Post $post The current post object (useful for creating categories only certain post types)
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
     * Super simple way to register a new Gutenberg block
     *
     * @param string $slug A unique slug for this block
     * @param string $file The name of the block JS
     */
    public static function add_block($slug, $file)
    {

        wp_register_script(
            $slug,
            Core::i()->urls->js('gutenberg/' . $file),
            ['wp-blocks', 'wp-i18n', 'wp-element']
        );

        register_block_type(
            self::NAMESPACE . '/' . $slug,
            [
                'editor_script' => $slug,
            ]
        );

        wp_add_inline_script(
            $slug,
            sprintf(
                'var %s = { localeData: %s };',
                WordPress::to_camelCase($slug),
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