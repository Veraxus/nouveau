// =====================================================================================================================
// THEME CUSTOMIZER JAVASCRIPT CONTROLS
//
// This file adds LIVE updates to the Theme Customizer live preview. To leverage this, set your custom settings to
// 'postMessage' and then add your handling here. Your javascript should grab settings from customizer controls, and
// then make any necessary changes to the page using jQuery. This compiles to assets/js/theme-customizer.min.js in your
// theme directory.
// =====================================================================================================================

( function( $ ) {

    // Update the site title in real time...
    wp.customize( 'blogname', function( value ) {           //Specify SETTING id here
        value.bind( function( newval ) {
            $( '#site-title a' ).html( newval );            //Define custom handling here (newval contains the new value)
        } );
    } );
    
    //Update the site description in real time...
    wp.customize( 'blogdescription', function( value ) {    //Specify SETTING id here
        value.bind( function( newval ) {
            $( '#site-description' ).html( newval );        //Define custom handling here (newval contains the new value)
        } );
    } );

    //Update site title color in real time...
    wp.customize( 'header_textcolor', function( value ) {
        value.bind( function( newval ) {
            $('#site-title a').css('color', newval );       //Modify any element(s) css style based on the settings' value (for example, color)
        } );
    } );

    //Update site background color...
    wp.customize( 'background_color', function( value ) {
        value.bind( function( newval ) {
            $('body').css('background-color', newval );     //Modify any element(s) css style based on the settings' value (for example, color)
        } );
    } );
    
    //Update site title color in real time...
    wp.customize( 'nouveau_theme_options[link_textcolor]', function( value ) {
        value.bind( function( newval ) {
            $('a').css('color', newval );                   //Modify any element(s) css style based on the settings' value (for example, color)
        } );
    } );
    
} )( jQuery );