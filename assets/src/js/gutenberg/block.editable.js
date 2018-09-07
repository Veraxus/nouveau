/* =====================================================================================================================
// Gutenberg Block: NOUVEAU Editable
//
// This file is loaded into your WordPress admin's Gutenberg editor. For more information on how to create custom
// Gutenberg blocks, see: https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/
//
// For icons, you can use anything from the WP Dashicons library ( https://developer.wordpress.org/resource/dashicons/ )
// just remember to remove the 'dashicons-' prefix. You can also provide your own SVGs (see below).
// ===================================================================================================================*/

const {registerBlockType} = wp.blocks;

// Which components do we need to bring in?
const { RichText } = wp.editor;

registerBlockType(
    // The block name you registered in Gutenberg::block_hello()
    'nouveau-theme/example-editable',

    // Configuration of the block
    {
        // The visible name of the block
        title: 'Text Block',

        // You can even provide custom SVGs!
        icon: (
            <svg aria-hidden="true" data-prefix="fas" data-icon="pen-square"
                 className="svg-inline--fa fa-pen-square fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 448 512">
                <path fill="#2795b6"
                      d="M400 480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48v352c0 26.5-21.5 48-48 48zM238.1 177.9L102.4 313.6l-6.3 57.1c-.8 7.6 5.6 14.1 13.3 13.3l57.1-6.3L302.2 242c2.3-2.3 2.3-6.1 0-8.5L246.7 178c-2.5-2.4-6.3-2.4-8.6-.1zM345 165.1L314.9 135c-9.4-9.4-24.6-9.4-33.9 0l-23.1 23.1c-2.3 2.3-2.3 6.1 0 8.5l55.5 55.5c2.3 2.3 6.1 2.3 8.5 0L345 199c9.3-9.3 9.3-24.5 0-33.9z"></path>
            </svg>
        ),

        // All blocks are sorted into categories. Which category
        category: 'nouveau-theme',

        // Defines how to process/convert block content before passing to edit or save
        attributes: {
            content: {
                type: 'array',
                source: 'children',
                selector: 'p',
            },
        },

        // How should the content be rendered in the editor?
        edit({attributes, className, setAttributes}) {
            const {content} = attributes;

            const onChangeContent = (newContent) => {
                setAttributes({content: newContent});
            };

            return (
                <RichText
                    tagName="p"
                    className={className}
                    onChange={onChangeContent}
                    value={content}
                />
            );
        },

        // What should content look like when it's saved to the db?
        save({attributes, className}) {
            const {content} = attributes;

            return (
                <RichText.Content
                    tagName="p"
                    className={className}
                    value={content}
                />
            );
        },
    }
);