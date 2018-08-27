// =====================================================================================================================
// Gutenberg Block: NOUVEAU Hello World
//
// This file is loaded into your WordPress admin's Gutenberg editor. For more information on how to create custom
// Gutenberg blocks, see: https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/
//
// For icons, you can use anything from the WP Dashicons library ( https://developer.wordpress.org/resource/dashicons/ )
// just remember to remove the 'dashicons-' prefix. You can also provide your own SVGs (see example editable block).
// =====================================================================================================================

const {registerBlockType} = wp.blocks;

// You can apply raw JS styling to the block!
const blockStyle = {
    backgroundColor: '#2795b6',
    color: '#fff',
    padding: '20px'
};

registerBlockType(
    // The block name you registered in php
    'nouveau-theme/example-hello',

    // Configuration of the block
    {
        // The visible name of the block
        title: 'Hello World',

        // You can use anythin in the Dashicons library ( https://developer.wordpress.org/resource/dashicons/ )
        icon: 'smiley',

        // All blocks are sorted into categories. Which category
        category: 'nouveau-theme',

        // How should the content be rendered in the editor?
        edit({className}) {
            return <p style={blockStyle} className={className}>Hello, NOUVEAU developer!</p>;
        },

        // What should content look like when it's saved to the db?
        save({className}) {
            return <p style={blockStyle} className={className}>Hello, site visitor!</p>;
        },
    }
);