// =============================================================================
// THEME CUSTOMIZER JAVASCRIPT CONTROLS
//
// This file adds LIVE updates to the Theme Customizer live preview. To leverage
// this, set your custom settings to 'postMessage' and then add your handling
// here. Your javascript should grab settings from customizer controls, and then
// make any necessary changes to the page using jQuery. This compiles to
// assets/js/theme-customizer.min.js in your theme directory.
// =============================================================================

(function($) {

  // Update the site title in real time...
  wp.customize('blogname', function(value) { // <-- Specify SETTING id here
    value.bind(function(newval) {
      //Define custom handling here (newval contains the new value)
      $('#site-title a').html(newval);
    });
  });

  //Update the site description in real time...
  wp.customize('blogdescription', function(value) {
    value.bind(function(newval) {
      //Define custom handling here (newval contains the new value)
      $('#site-description').html(newval);
    });
  });

  //Update site title color in real time...
  wp.customize('header_textcolor', function(value) {
    value.bind(function(newval) {
      // Modify any element(s) css style based on the settings' value (for
      // example, color)
      $('#site-title a').css('color', newval);
    });
  });

  //Update site background color...
  wp.customize('background_color', function(value) {
    value.bind(function(newval) {
      // Modify any element(s) css style based on the settings' value (for
      // example, color)
      $('body').css('background-color', newval);
    });
  });

  //Update site title color in real time...
  wp.customize('nouveau_theme_options[link_textcolor]', function(value) {
    value.bind(function(newval) {
      // Modify any element(s) css style based on the settings' value (for
      // example, color)
      $('a').css('color', newval);
    });
  });

})(jQuery);