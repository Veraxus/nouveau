// =====================================================================================================================
// Gutenberg Scripts
//
// This file is loaded into your WordPress admin's Gutenberg editor. For more information on how to create custom
// Gutenberg blocks, see: https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/
// =====================================================================================================================

const {registerBlockType} = wp.blocks;
const blockStyle = {backgroundColor: '#900', color: '#fff', padding: '20px'};

registerBlockType('gutenberg-boilerplate-esnext/hello-world-step-01',
    {
        title: 'Hello World (Step 1)',
        icon: 'universal-access-alt',
        category: 'layout',

        edit() {
            return <p style={blockStyle}>Hello editor.</p>;
        },

        save() {
            return <p style={blockStyle}>Hello saved content.</p>;
        },
    }
);