/**
 * PRIMARY THEME JAVASCRIPT FILE
 *
 * This is your public-facing, front-end Javascript. It compiles to assets/js/app.min.js in your theme directory.
 *
 * This is used to initialize your custom Javascript. If you would like to change how Foundation and it's plugins are
 * initialized, you can. See http://foundation.zurb.com/docs/javascript.html for documentation.
 */
jQuery(function( $ ) {

    // Initialize foundation with all plugins (but change the top bar)
    $(document).foundation('topbar', {
        stickyClass: 'stick-to-top'
    });

    // Your code goes here

});