// =====================================================================================================================
// Gutenberg Block: NOUVEAU Hello World
//
// This file is loaded into your WordPress admin's Gutenberg editor. For more information on how to create custom
// Gutenberg blocks, see: https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/
// =====================================================================================================================

const {registerBlockType} = wp.blocks;

// You can apply raw JS styling to the block!
const blockStyle = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px'
};

registerBlockType(
    // The block name you registered in Gutenberg::block_hello()
    'nouveau-theme/example-hello',

    // Configuration of the block
    {
        // The visible name of the block
        title: 'Hello World',

        // You can use anythin in the Dashicons library ( https://developer.wordpress.org/resource/dashicons/ )
        icon: 'universal-access-alt',

        // All blocks are sorted into categories. Which category
        category: 'nouveau-theme',

        // This will show in the Gutenberg editor
        edit({className}) {
            return <p style={blockStyle} className={className}>Hello, Gutenberg user!</p>;
        },

        // This will show on the rendered webpage
        save({className}) {
            return <p style={blockStyle} className={className}>Hello, site visitor!</p>;
        },
    }
);